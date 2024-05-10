<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Watchlist;
use App\Models\Instrument;
use App\Models\DataBanksEod;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CompanyBasicInfo;
use App\Models\DataBanksIntraday;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\Object_;
use App\Models\CompanyBoardOfDirectors;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CompanyApiController extends Controller
{
    private function calculateVariance($array)
    {
        $mean = array_sum($array) / count($array);
        $variance = 0.0;
        foreach ($array as $value) {
            $variance += pow($value - $mean, 2);
        }
        return $variance / count($array); // Population variance
    }

    private function calculateCovariance($array1, $array2)
    {
        if (count($array1) !== count($array2)) {
            return null; // Arrays must have the same length
        }

        $mean1 = array_sum($array1) / count($array1);
        $mean2 = array_sum($array2) / count($array2);
        $covariance = 0;

        for ($i = 0; $i < count($array1); $i++) {
            $covariance += ($array1[$i] - $mean1) * ($array2[$i] - $mean2);
        }

        return $covariance / count($array1); // Population covariance
    }


    private function calculateBeta($instrumentId, $today)
    {
        // Query the database to fetch necessary data for beta calculation
        $priceData = DataBanksEod::select('close', 'date')
            ->where('instrument_id', $instrumentId)
            ->where('date', '<=', $today)
            ->orderBy('date', 'desc')
            ->limit(360)
            ->get();

        $marketId = 10001;
        // Query market index data
        $marketIndexData = DataBanksEod::select('close', 'date')
            ->where('instrument_id', $marketId)
            ->where('date', '<=', $today)
            ->orderBy('date', 'desc')
            ->limit(360)
            ->get();

        // Ensure both data sets are not empty
        if ($priceData->isEmpty() || $marketIndexData->isEmpty()) {
            return null; // Not enough data points for beta calculation
        }

        // Align data by date
        $priceData = $priceData->sortBy('date');
        $marketIndexData = $marketIndexData->sortBy('date');
        // dd($priceData->sortBy('date')->toArray());
        // dd($marketIndexData->sortBy('date')->toArray());

        // Extract close prices from price data for the stock and market index
        $closePricesStock = $priceData->pluck('close')->toArray();
        $closePricesMarket = $marketIndexData->pluck('close')->toArray();
        // dd($priceData->pluck('close', 'date')->toArray());

        // Calculate returns for the stock and market index
        $returnsStock = $this->calculateReturns($closePricesStock);
        $returnsMarket = $this->calculateReturns($closePricesMarket);
        // dd($returnsStock);

        // Calculate covariance between stock returns and market returns
        $covariance = $this->calculateCovariance($returnsStock, $returnsMarket);

        // Calculate variance of market returns
        $varianceMarket = $this->calculateVariance($returnsMarket);

        // Calculate beta
        if ($varianceMarket != 0) {
            $beta = $covariance / $varianceMarket;
            return $beta;
        } else {
            return null; // Avoid division by zero
        }
    }

    private function calculateReturns($prices)
    {
        $returns = [];

        for ($i = 1; $i < count($prices); $i++) {
            // Check if the denominator is zero before performing division
            if ($prices[$i - 1] != 0) {
                $returns[] = (($prices[$i] - $prices[$i - 1]) / $prices[$i - 1]);
            } else {
                $returns[] = null;
            }
        }

        return $returns;
    }

    public function companyMarketSummary(Request $request)
    {
        $today = $request->tdate;
        $symbol = $request->q;
        // $today = '2023-01-24';
        // $symbol = 'ABBANK';

        // // Debugging statements
        // dd($today, $symbol);

        // Calculate current date and one year ago
        $current_date = Carbon::parse($today);
        $previous_one_year_date_fetch = $current_date->copy()->subYear();
        $previous_one_year_date = $previous_one_year_date_fetch->format('Y-m-d');

        // dd($today, $previous_one_year_date);

        $company = Instrument::select('id')->where('instrument_code', '=', $symbol)->first();

        // dd($company->id);

        if (!$company) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')
            ->select('id', 'instrument_id', 'trade_date', 'open_price', 'high_price', 'low_price', 'pub_last_traded_price', 'total_volume', 'yday_close_price')
            ->where('trade_date', '=', $today)
            ->where('instrument_id', '=', $company->id)
            ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
            ->orderBy('lm_date_time', 'DESC')
            ->first();

        if (!$collections) {
            $collections = (object) [];
            $collections->instrument = Instrument::select('id', 'instrument_code as name')
                ->where('id', $company->id)
                ->first();
            $collections->yday_close_price = null;
            $collections->pub_last_traded_price = null;
        }

        // Retrieve EOD data for the previous one year
        $collections_eod = DataBanksEod::where('instrument_id', '=', $company->id)
            ->whereBetween('date', [$previous_one_year_date, $current_date])
            ->orderBy('low', 'ASC')
            ->selectRaw('MIN(low) as one_year_lowest_price, MAX(high) as one_year_highest_price')
            ->first();

        // Add one-year EOD data to the collections
        $collections->one_year_lowest_price = $collections_eod->one_year_lowest_price;
        $collections->one_year_highest_price = $collections_eod->one_year_highest_price;

        // Save yesterday's close price from intraday data
        $yday_close_price_intraday = $collections->yday_close_price;
        // dd($yday_close_price_intraday);

        // Retrieve close price from EOD data
        $close_price_eod = DataBanksEod::select('close')
            ->where('instrument_id', '=', $company->id)
            ->where('date', '=', $today)
            ->first();

        // Retrieve outstanding securities number
        $outstanding_securities_no = CompanyBasicInfo::select('outstanding_securities_no')->where('code', '=', $symbol)->first();
        // $outstanding_securities_no = null;

        $market_capitalization = null;

        if ($close_price_eod != null && $close_price_eod->close <= 0) {
            $market_capitalization = $outstanding_securities_no->outstanding_securities_no * $yday_close_price_intraday;
        } elseif ($close_price_eod != null && $close_price_eod->close > 0) {
            $market_capitalization = $outstanding_securities_no->outstanding_securities_no * $close_price_eod->close;
        } else {
            $market_capitalization = null;
        }

        // Add market capitalization to collections
        $collections->market_capitalization = $market_capitalization;
        //dd($collections->market_capitalization);

        $last_id = DataBanksEod::where('instrument_id', '=', $company->id)
            ->where('date', '=', $today)
            ->max('id');

        // dd($last_id);

        if ($last_id != null) {
            $volume = DataBanksEod::select('volume as public_total_volume')
                ->where('instrument_id', '=', $company->id)
                ->where('id', '<', $last_id)
                ->orderBy('id', 'DESC')
                ->limit(22)
                ->get();

            // dd($volume);

            $public_total_volume = $volume->pluck('public_total_volume')->toArray();
            // dd($public_total_volume);

            $total_volume_sum = array_sum($public_total_volume);

            $total_volume_count = count($public_total_volume);
            // dd($total_volume_sum, $total_volume_count);

            $average_volume = $total_volume_sum / $total_volume_count;
            // dd($average_volume);

            $collections->average_volume = $average_volume;
        }

        $last_audited_year = DB::raw("(SELECT MAX(audited_year) FROM company_financial_performance_audited WHERE company_id = $company->id)");
        // $last_audited_year = null;
        $company_id = $company->id;

        if ($last_audited_year !== null) {
            $data = DB::table('company_financial_performance_audited as audited')
                ->select('audited.original_basic_eps_co', 'agm.cash_dividend_value', 'agm.stock_dividend_value', 'continued.dividend_yield_in')
                ->leftJoin('company_agm_information as agm', function ($join) use ($last_audited_year, $company_id) {
                    $join->on('agm.company_id', '=', DB::raw($company_id))->where('agm.agm_year', $last_audited_year);
                })
                ->leftJoin('company_financial_performance_continued as continued', function ($join) use ($last_audited_year, $company_id) {
                    $join->on('continued.company_id', '=', DB::raw($company_id))->where('continued.continued_year', $last_audited_year);
                })
                ->where('audited.company_id', $company->id)
                ->where('audited.audited_year', $last_audited_year)
                ->first();

            if ($data !== null) {
                $collections->eps = $data->original_basic_eps_co ?? 0.0;
                $collections->pe_ratio_ttm = $collections->pub_last_traded_price / ($data->original_basic_eps_co ?? 0.0);
                $collections->cash_dividend = $data->cash_dividend_value ?? 0.0;
                $collections->stock_dividend = $data->stock_dividend_value ?? 0.0;
                $collections->dividend_yield = $data->dividend_yield_in ?? 0.0;
            }
        }

        // $rsi = $this->calculateRSI($instrument->id, $today, $trade_batch);
        $beta = $this->calculateBeta($company->id, $today);
        $collections->beta = $beta;

        $response = [
            'data' => $collections,
            'status' => 'success',
        ];
        return response()->json($response);
    }


    public function companyDetailsHeader(Request $request)
    {
        //        API Testing demo data
        $today = $request->tdate;
        // $symbol = "AAMRANET";
        $symbol = $request->q;

        if (!$symbol) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        $company = Instrument::select('id')->where('instrument_code', '=', $symbol)->first();

        $collections = (object) [];
        //        $today = date('Y-m-d');
        if ($company) {
            $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')
                ->select('id', 'instrument_id', 'trade_date', 'yday_close_price')
                ->selectRaw('CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price')
                ->selectRaw('CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - yday_close_price) * 100 ) / yday_close_price ELSE ((pub_last_traded_price - yday_close_price) * 100) / yday_close_price END AS pchange')
                ->selectRaw('CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price - open_price ELSE pub_last_traded_price - open_price  END AS rchange')
                ->where('trade_date', '=', $today)
                ->where('instrument_id', '=', $company->id)
                ->orderBy('lm_date_time', 'DESC')
                ->limit(1)
                ->first();
        }
        // Need to Show Company Basic Information From Company Table But Company Table Not Connected to Instrument Table.
        // OR Need to join query using instrument_code in instrument table and company table using code

        //        $companyInfo = Company::select('id','code','name')
        //            ->where('id','=',$company)
        //            ->get();

        $response = [
            'data' => $collections ? $collections : (object) [],
            'status' => 'success',
        ];
        return response()->json($response);
    }

    public function historicalData(Request $request)
    {
        $page = $request->page;
        $limit = 30;
        $offset = ($page - 1) * $limit;

        $today = $request->tdate;
        $symbol = $request->q;
        // DB::enableQueryLog();

        $company = Instrument::select('id')->where('instrument_code', '=', $symbol)->first();
        $collections = DataBanksEod::with('instrument:id,instrument_code as name')
            ->select('id', 'date', 'instrument_id', 'open', 'high', 'low', 'close', 'volume')
            ->where('instrument_id', '=', $company->id)
            ->orderBy('date', 'DESC')
            ->offset($offset)
            ->limit($limit)
            ->get();
        // dd(DB::getQueryLog());
        $response = [
            'data' => $collections,
            'status' => 'success',
        ];
        return response()->json($response);
    }

    public function companyProfile(Request $request)
    {
        // $company = $request->q;
        $symbol = $request->q;

        $company = Instrument::select('id')->where('instrument_code', '=', $symbol)->first();
        $companyInfo = CompanyBasicInfo::select('id', 'company_name', 'instrument_id', 'company_description', 'incorporation_date', 'corporate_office_address', 'head_office_address', 'factory_office_address', 'fax', 'phone')
            // ->where('id', '=', $company->id)
            ->where('code', '=', $symbol)
            // ->orderBy('date','DESC')
            // ->limit(10)
            ->first();

        $companyBoardOfDirctors = DB::table('company_board_of_directors')
            ->join('director_profiles', 'company_board_of_directors.directors_profiles_id', '=', 'director_profiles.id')
            ->join('designations', 'company_board_of_directors.designation_id', '=', 'designations.id')
            ->select('company_board_of_directors.id', 'company_board_of_directors.share_percentage', 'company_board_of_directors.start_date', 'company_board_of_directors.email', 'company_board_of_directors.phone', 'director_profiles.name as directorName', 'designations.name')
            ->where('company_id', '=', $company->id)
            ->get();

        $response = [
            'data' => [
                'companyInfo' => $companyInfo,
                'companyBoardOfDirctors' => $companyBoardOfDirctors,
            ],
            'status' => 'success',
        ];
        return response()->json($response);
    }

    public function companyList(Request $request)
    {
        // DB::enableQueryLog();
        try {
            $page = $request->page;
            $limit = 20;
            $offset = ($page - 1) * $limit;
            $companies = DB::table('company')->leftJoin('instruments', 'company.code', '=', 'instruments.instrument_code')->leftJoin('sector', 'sector.id', '=', 'instruments.sector_list_id')->select('company.id as company_id', 'company.name as company_name', 'company.code as code', 'instruments.id as instruments_id', 'instruments.instrument_code as instruments_code', 'sector.name as sector_name', 'instruments.sector_list_id as sector_list_id')->orderBy('company.name', 'ASC')->offset($offset)->limit($limit)->get();

            $sector = DB::table('sector')
                //    ->leftJoin('instruments', 'sector.id', '=', 'instruments.sector_list_id')
                ->select('sector.id', 'sector.name as sector_name')
                ->get();

            $companynamelist = DB::table('company')->select('company.name as company_name', 'company.id as company_id')->get();

            $response = [
                'data' => [
                    'companies' => $companies,
                    'sector' => $sector,
                    'companynamelist' => $companynamelist,
                ],
                'status' => 'success',
            ];

            // dd(DB::getQueryLog());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = [
                'data' => $e->getMessage(),
                'status' => 'error',
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function CompanySearchList(Request $request)
    {
        try {
            $symbol = $request->query('symbol');
            $sector = $request->query('sector');
            $search = $request->query('search');
            $company = DB::table('company')->leftJoin('instruments', 'company.code', '=', 'instruments.instrument_code')->leftJoin('sector', 'sector.id', '=', 'instruments.sector_list_id')->select('company.id as company_id', 'company.name as company_name', 'company.code as code', 'sector.name as sector_name', 'instruments.sector_list_id as sector_list_id');

            if (!empty($symbol)) {
                $company = $company->where('company.id', $symbol);
            }

            if (!empty($sector)) {
                $company = $company->where('sector.id', $sector);
            }

            if (!empty($search)) {
                $company = $company->where(function ($query) use ($search) {
                    $query
                        ->where('company.name', 'like', '%' . $search . '%')
                        ->orWhere('company.code', 'like', '%' . $search . '%')
                        ->orWhere('sector.name', 'like', '%' . $search . '%');
                });
            }

            $company = $company->get();

            $response = [
                'data' => $company,
                'status' => 'success',
            ];
            return response()->json($response);
        } catch (HttpException $e) {
            $response = [
                'data' => $e->getMessage(),
                'status' => 'error',
            ];
            return response()->json($response);
        }
    }
    public function addToWatchlist(Request $request)
    {
        $portal_user_id = $request->input('portal_user_id');
        $instrument_id = $request->input('instrument_id');
        $rules = [
            'instrument_id' => ['required', 'unique:watchlists,instrument_id,NULL,id,portal_user_id,' . $portal_user_id],
        ];
        $messages = [
            'instrument_id.unique' => 'The instrument is already added to the watchlist.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $watchlist = Watchlist::create([
            'instrument_id' => $instrument_id,
            'portal_user_id' => $portal_user_id,
        ]);
        $watchlist['success'] = 'Added to watchlist successfully!';
        return response()->json($watchlist, 200);
    }

    public function WatchlistIndex(Request $request)
    {
        $today = $request->date;
        $portal_user_id = $request->portal_user_id;
        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')
            ->select('data_banks_intradays.id', 'data_banks_intradays.instrument_id', 'data_banks_intradays.trade_date', 'data_banks_intradays.open_price')
            ->selectRaw('CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price')
            ->selectRaw('CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - open_price) * 100 ) / open_price ELSE ((pub_last_traded_price - open_price) * 100) / open_price END AS pchange')
            ->selectRaw('CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price - open_price ELSE pub_last_traded_price - open_price END AS rchange')
            ->selectRaw('yday_close_price')
            ->where('trade_date', '=', $today)
            ->whereIn('instrument_id', function ($query) use ($portal_user_id) {
                $query->select('instrument_id')->from('watchlists')->where('portal_user_id', '=', $portal_user_id);
            })
            ->whereRaw("id IN (SELECT MAX(id) FROM data_banks_intradays WHERE trade_date = '$today' GROUP BY instrument_id)")
            ->orderBy('pchange', 'DESC')
            ->get();
        $response = [
            'data' => $collections,
            'status' => 'success',
        ];
        return response()->json($response);
    }

    private static function calculateAverageVolume($instrumentId, $today, $numDays)
            {
                $lastId = DataBanksEod::where('instrument_id', $instrumentId)->where('date', $today)->max('id');

                $volume = DataBanksEod::select('volume as public_total_volume')->where('instrument_id', $instrumentId)->where('id', '<', $lastId)->orderBy('id', 'DESC')->limit($numDays)->get();

                $publicTotalVolume = $volume->pluck('public_total_volume')->toArray();
                $totalVolumeSum = array_sum($publicTotalVolume);
                $totalVolumeCount = count($publicTotalVolume);
                $averageVolume = $totalVolumeCount > 0 ? $totalVolumeSum / $totalVolumeCount : 0;

                // Debugging: return the values for inspection
                // return [
                //     'publicTotalVolume' => $publicTotalVolume,
                //     'totalVolumeSum' => $totalVolumeSum,
                //     'totalVolumeCount' => $totalVolumeCount,
                //     'averageVolume' => $averageVolume,
                // ];
                return $averageVolume;
            }

    public function companyStatistics(Request $request)
    {
        $today = $request->tdate;
        $symbol = $request->q;
        // $today = '2023-01-24';
        // $symbol = 'ABBANK';

        // // Debugging statements
        // dd($today, $symbol);

        // Calculate current date and one year ago
        $current_date = Carbon::parse($today);
        $previous_one_year_date_fetch = $current_date->copy()->subYear();
        $previous_one_year_date = $previous_one_year_date_fetch->format('Y-m-d');

        // dd($today, $previous_one_year_date);

        $company = Instrument::select('id')->where('instrument_code', '=', $symbol)->first();

        // dd($company->id);

        // Initialize collections
        $collections = (object) [];
        $collections->instrument = Instrument::select('id', 'instrument_code as name')
            ->where('id', $company->id)
            ->first();

        $intraday_data = DataBanksIntraday::with('instrument:id,instrument_code as name')
            ->select('id', 'instrument_id', 'trade_date', 'open_price', 'high_price', 'low_price', 'pub_last_traded_price', 'total_volume', 'yday_close_price')
            ->where('trade_date', '=', $today)
            ->where('instrument_id', '=', $company->id)
            ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
            ->orderBy('lm_date_time', 'DESC')
            ->first();

        if (!$intraday_data) {
            $collections = (object) [];
            $collections->instrument = Instrument::select('id', 'instrument_code as name')
                ->where('id', $company->id)
                ->first();
            $intraday_data = (object) [];
            $intraday_data->yday_close_price = null;
            $intraday_data->pub_last_traded_price = null;
        }

        // Retrieve EOD data for the previous one year
        $eod_data = DataBanksEod::where('instrument_id', '=', $company->id)
            ->whereBetween('date', [$previous_one_year_date, $current_date])
            ->orderBy('low', 'ASC')
            ->selectRaw('MIN(low) as one_year_lowest_price, MAX(high) as one_year_highest_price')
            ->first();
        // $eod_data = null;
        // dd($eod_data);

        if ($eod_data !== null) {
            // Retrieve the close price last year date
            $close_price_last_year_date = DataBanksEod::where('instrument_id', $company->id)
                ->whereBetween('date', [$previous_one_year_date, $current_date])
                ->orderBy('date', 'asc')
                ->value('close');

            // Retrieve the last stock price
            $current_stock_close_price = DataBanksEod::where('instrument_id', $company->id)
                ->whereBetween('date', [$previous_one_year_date, $current_date])
                ->orderBy('date', 'desc')
                ->value('close');

            // Calculate the change in price
            $change_in_price = $current_stock_close_price - $close_price_last_year_date;
            // dd($change_in_price);

            // Calculate the percentage change
            if ($close_price_last_year_date != 0) {
                $percentage_change = ($change_in_price / $close_price_last_year_date) * 100;
            } else {
                $percentage_change = 0; // Avoid division by zero error
            }

            // Add one-year EOD data to the collections
            $collections->one_year_lowest_price = $eod_data->one_year_lowest_price;
            $collections->one_year_highest_price = $eod_data->one_year_highest_price;
            $collections->current_stock_close_price = $current_stock_close_price;
            $collections->close_price_last_year_date = $close_price_last_year_date;
            $collections->percentage_change = $percentage_change;

            function calculateMovingAverage($instrumentId, $startDate, $endDate, $numDays)
            {
                // Retrieve the closing prices for the past $numDays trading days
                $closing_prices = DataBanksEod::where('instrument_id', $instrumentId)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->orderBy('date', 'desc')
                    ->limit($numDays)
                    ->pluck('close')
                    ->toArray();

                // Add up the closing prices
                $sum_of_closing_prices = array_sum($closing_prices);

                // Calculate the moving average
                if (count($closing_prices) > 0) {
                    $moving_average = $sum_of_closing_prices / count($closing_prices);
                    // $moving_average = round($moving_average, 2); // Round to two decimal places
                } else {
                    $moving_average = 0; // No closing prices available
                }

                return $moving_average;
            }

            // Usage for 50-Day Moving Average
            $startDate = $previous_one_year_date; // Define $previous_one_year_date and $current_date accordingly
            $endDate = $current_date;
            $numDays50 = 50;
            $moving_average_50 = calculateMovingAverage($company->id, $startDate, $endDate, $numDays50);
            // dd($moving_average_50);
            $collections->moving_average_50 = $moving_average_50;

            // Usage for 200-Day Moving Average
            $numDays200 = 200;
            $moving_average_200 = calculateMovingAverage($company->id, $startDate, $endDate, $numDays200);
            $collections->moving_average_200 = $moving_average_200;
        }

        if ($intraday_data) {

            $numDays3month = 90;
            $average_volume_3month = $this->calculateAverageVolume($company->id, $today, $numDays3month);
          
            $collections->average_volume_3month = $average_volume_3month;

            $numDays10day = 10;
            $average_volume_10day = $this->calculateAverageVolume($company->id, $today, $numDays10day);
            $collections->average_volume_10day = $average_volume_10day;
        }

        // Debugging: inspect the returned values
        //dd($average_volume_3month['publicTotalVolume'], $average_volume_3month['totalVolumeSum'], $average_volume_3month['totalVolumeCount']);

        // Save yesterday's close price from intraday data
        $pub_last_traded_price = $intraday_data->pub_last_traded_price;
        // dd($pub_last_traded_price);

        // Retrieve outstanding securities number
        $outstanding_securities_no = CompanyBasicInfo::select('outstanding_securities_no')->where('code', '=', $symbol)->first();
        // $outstanding_securities_no = null;

        if ($outstanding_securities_no !== null) {
            $collections->outstanding_shares_no = $outstanding_securities_no->outstanding_securities_no;

            $market_capitalization_intraday = null;

            $market_capitalization_intraday = $outstanding_securities_no->outstanding_securities_no * $pub_last_traded_price;

            // Add market capitalization to collections
            $collections->market_capitalization_intraday = $market_capitalization_intraday;
        }

        $last_audited_year = DB::raw("(SELECT MAX(audited_year) FROM company_financial_performance_audited WHERE company_id = $company->id)");
        // $last_audited_year = null;
        $company_id = $company->id;

        if ($last_audited_year !== null) {
            $financial_data = DB::table('company_financial_performance_audited as audited')
                ->select('audited.original_basic_eps_co', 'agm.cash_dividend_value', 'agm.stock_dividend_value', 'continued.dividend_yield_in')
                ->leftJoin('company_agm_information as agm', function ($join) use ($last_audited_year, $company_id) {
                    $join->on('agm.company_id', '=', DB::raw($company_id))->where('agm.agm_year', $last_audited_year);
                })
                ->leftJoin('company_financial_performance_continued as continued', function ($join) use ($last_audited_year, $company_id) {
                    $join->on('continued.company_id', '=', DB::raw($company_id))->where('continued.continued_year', $last_audited_year);
                })
                ->where('audited.company_id', $company->id)
                ->where('audited.audited_year', $last_audited_year)
                ->first();

            // $financial_data = null;

            $collections->pe_ratio_ttm = $intraday_data->pub_last_traded_price / ($financial_data->original_basic_eps_co ?? 0.0);
        }

        $response = [
            'data' => $collections,
            'status' => 'success',
        ];
        return response()->json($response);
    }

    public function companyShareHolding(Request $request)
    {
        $today = $request->tdate;
        $symbol = $request->q;
        // $today = '2023-01-24';
        // $symbol = 'ABBANK';

        // // Debugging statements
        // dd($today, $symbol);
        if (!$symbol) {
            $response = [
                'data' => (object) [],
                'status' => 'no symbol',
            ];
            return response()->json($response);
        }

        // Calculate current date and one year ago
        $current_date = Carbon::parse($today);
        $previous_one_year_date_fetch = $current_date->copy()->subYear();
        $previous_one_year_date = $previous_one_year_date_fetch->format('Y-m-d');

        // dd($today, $previous_one_year_date);

        $company = Instrument::select('id')->where('instrument_code', '=', $symbol)->first();
        if (!$company) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        // dd($company->id);

        // Initialize collections
        $collections = (object) [];
        $collections->instrument = Instrument::select('id', 'instrument_code as name')
            ->where('id', $company->id)
            ->first();

        $shareHoldings = DB::table('company_share_holding')
            ->select('share_holding_date', 'sponsor_director_value', 'govt_value', 'institute_value', 'foreign_value', 'public_value')
            ->where('company_id', '=', $company->id)
            ->orderBy('share_holding_date', 'asc')
            ->groupBy('share_holding_date')
            ->get();

        if (!$shareHoldings) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        $collections->company_shares = $shareHoldings;

        $response = [
            'data' => $collections,
            'status' => 'success',
        ];
        return response()->json($response);
    }

    public function companyFinancialStatement(Request $request)
    {
        $today = $request->tdate;
        $symbol = $request->q;
        // $today = '2023-01-24';
        // $symbol = 'ABBANK';

        // // Debugging statements
        // dd($today, $symbol);
        if (!$symbol) {
            $response = [
                'data' => (object) [],
                'status' => 'no symbol',
            ];
            return response()->json($response);
        }

        // Calculate current date and one year ago
        $current_date = Carbon::parse($today);
        $previous_one_year_date_fetch = $current_date->copy()->subYear();
        $previous_one_year_date = $previous_one_year_date_fetch->format('Y-m-d');

        // dd($today, $previous_one_year_date);

        $company = Instrument::select('id')->where('instrument_code', '=', $symbol)->first();
        if (!$company) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        // dd($company->id);

        // Initialize collections
        $collections = (object) [];
        $collections->instrument = Instrument::select('id', 'instrument_code as name')
            ->where('id', $company->id)
            ->first();

        $FinancialStatementPdf = DB::table('company_financial_statements')
            ->select('date_time', 'quatar_text', 'file')
            ->where('instrument_id', '=', $company->id)
            ->orderBy('date_time', 'asc')
            ->groupBy('date_time')
            ->get();

        if (!$FinancialStatementPdf) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        $collections->financial_statement_pdf = $FinancialStatementPdf;

        $response = [
            'data' => $collections,
            'status' => 'success',
        ];
        return response()->json($response);
    }

    public function minuteChart(Request $request)
    {
        $today = $request->tdate;
        $symbol = $request->q;
        $trade_batch = $request->trade_batch;
        $lastId = $request->last_id;

        $company = Instrument::select('id')->where('instrument_code', '=', $symbol)->first();
        if (!$company) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        $collections = (object) [];

        // Query the database to fetch minute chart data
        $minuteChartDataQuery = DataBanksIntraday::select('id', 'trade_time', 'pub_last_traded_price', 'public_total_volume')
            ->where('instrument_id', '=', $company->id)
            ->where('batch', '=', $trade_batch)
            ->orderBy('trade_time', 'desc')
            ->groupBy('trade_time', 'pub_last_traded_price', 'public_total_volume')
            ->havingRaw('COUNT(*) > 1')
            ->take(20)
            ->get();


        if ($lastId) {
            $minuteChartDataQuery->where('id', '>', $lastId);
        }

        $minuteChartData = $minuteChartDataQuery->sortBy('trade_time')->values()->all();
        if (!$minuteChartData) {
            $response = [
                'data' => (object) [],
                'status' => 'success',
            ];
            return response()->json($response);
        }

        $previousVolume = null;

        foreach ($minuteChartData as $dataPoint) {

            if ($previousVolume !== null) {
                $dataPoint->volume_change = $dataPoint->public_total_volume - $previousVolume;
            } else {

                $dataPoint->volume_change = 0;
            }


            $previousVolume = $dataPoint->public_total_volume;
        }


        $collections->minuteChartData = $minuteChartData;

        $response = [
            'data' => $collections,
            'status' => 'success',
        ];

        return response()->json($response);
    }
}
