<?php

namespace App\Http\Controllers\Api;

use App\Models\Market;
use App\Models\IndexValue;
use Illuminate\Http\Request;
use App\Models\DataBanksIntraday;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DataBanksEod;
use App\Models\Instrument;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AnalyticalController extends Controller
{
    public function getSingleRow($row, $trade_date, $trade_batch)
    {
        $close = DataBanksEod::where('instrument_id', '=', $row->instrument_id)
            ->where('date', '=', $trade_date)
            ->value('close');

        if ($close > 0) {
            $last_id = DataBanksEod::where('instrument_id', '=', $row->instrument_id)
                ->where('date', '=', $trade_date)
                ->max('id');

            $single_row = DataBanksEod::select('id', 'date as trade_date', 'close as pub_last_traded_price', 'volume as public_total_volume')
                ->where('instrument_id', '=', $row->instrument_id)
                ->where('id', '<=', $last_id)
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
        } elseif ($close <= 0) {
            $single_row = DataBanksIntraday::select('id', 'trade_date', 'pub_last_traded_price', 'public_total_volume')
                ->where('instrument_id', '=', $row->instrument_id)
                ->where('batch', '=', $trade_batch)
                ->orderBy('id', 'DESC')
                ->limit(1)
                ->get();

            $last_id = DataBanksEod::where('instrument_id', '=', $row->instrument_id)
                ->where('date', '=', $trade_date)
                ->max('id');

            $single_row_eod = DataBanksEod::select('id', 'date as trade_date', 'close as pub_last_traded_price', 'volume as public_total_volume')
                ->where('instrument_id', '=', $row->instrument_id)
                ->where('id', '<', $last_id)
                ->orderBy('id', 'DESC')
                ->limit(9)
                ->get();

            $single_row = $single_row->merge($single_row_eod);
        }

        return $single_row;
    }


    public function gainerSparkline(Request $request)
    {

        // $today = '2023-01-19';
        // $trade_batch = 160;
        $today = $request->tdate;
        $trade_batch = $request->trade_batch;


        //    DB::enableQueryLog();
        $gainer = DataBanksIntraday::select('instrument_id', 'trade_date', 'yday_close_price', 'public_total_value')
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - yday_close_price) * 100 ) / yday_close_price ELSE ((pub_last_traded_price - yday_close_price) * 100) / yday_close_price END AS pchange")
            // ->where('trade_date', '=', $today)
            ->where('batch', '=', $trade_batch)
            ->whereRaw("id in (select max(id) from data_banks_intradays where batch='$trade_batch' group by (instrument_id))")
            ->whereRaw("(CASE  WHEN pub_last_traded_price = 0 THEN spot_last_traded_price > yday_close_price ELSE pub_last_traded_price > yday_close_price END)")
            ->orderBy('pchange', 'DESC')
            ->limit(10)
            ->get();

        $trade_date = $gainer->isEmpty() ? null : $gainer->first()->trade_date;
        // dd(['trade_date' => $trade_date]);

        // dd(DB::getQueryLog());

        foreach ($gainer as $key => $row) {
            $single_row = $this->getSingleRow($row, $trade_date, $trade_batch);
            $gainer[$key]['last_record'] = $single_row;
        }

        $response = array(
            'data' => array(
                'gainer' => $gainer,
            ),
            'status' => 'success',
        );
        return response()->json($response);
    }
    public function losserSparkline(Request $request)
    {

        // $today = '2023-01-19';
        // $trade_batch = 160;
        $today = $request->tdate;
        $trade_batch = $request->trade_batch;
        //    DB::enableQueryLog();
        $looser = DataBanksIntraday::select('instrument_id', 'trade_date', 'yday_close_price', 'public_total_value')
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - yday_close_price) * 100 ) / yday_close_price ELSE ((pub_last_traded_price - yday_close_price) * 100) / yday_close_price END AS pchange")
            ->where('batch', '=', $trade_batch)
            ->whereRaw("id in (select max(id) from data_banks_intradays where batch='$trade_batch' group by (instrument_id))")
            ->whereRaw("(CASE  WHEN pub_last_traded_price = 0 THEN spot_last_traded_price < yday_close_price ELSE pub_last_traded_price < yday_close_price END)")
            ->orderBy('pchange', 'DESC')
            ->limit(10)
            ->get();

        $trade_date = $looser->isEmpty() ? null : $looser->first()->trade_date;
        // dd(['trade_date' => $trade_date]);

        // dd(DB::getQueryLog());

        foreach ($looser as $key => $row) {
            $single_row = $this->getSingleRow($row, $trade_date, $trade_batch);
            $looser[$key]['last_record'] = $single_row;
        }

        $response = array(
            'data' => array(
                'looser' => $looser,
            ),
            'status' => 'success',
        );
        return response()->json($response);
    }
    public function topValueSparkline(Request $request)
    {

        // $today = '2023-01-19';
        // $trade_batch = 160;
        $today = $request->tdate;
        $trade_batch = $request->trade_batch;


        //    DB::enableQueryLog();
        $gainer = DataBanksIntraday::select('instrument_id', 'trade_date', 'yday_close_price', 'public_total_value','total_value')
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - yday_close_price) * 100 ) / yday_close_price ELSE ((pub_last_traded_price - yday_close_price) * 100) / yday_close_price END AS pchange")
            // ->where('trade_date', '=', $today)
            ->where('batch', '=', $trade_batch)
            ->whereRaw("id in (select max(id) from data_banks_intradays where batch='$trade_batch' group by (instrument_id))")

            ->orderBy('total_value', 'DESC')
            ->limit(10)
            ->get();

        $trade_date = $gainer->isEmpty() ? null : $gainer->first()->trade_date;
        // dd(['trade_date' => $trade_date]);

        // dd(DB::getQueryLog());

        foreach ($gainer as $key => $row) {
            $single_row = $this->getSingleRow($row, $trade_date, $trade_batch);
            $gainer[$key]['last_record'] = $single_row;
        }

        $response = array(
            'data' => array(
                'gainer' => $gainer,
            ),
            'status' => 'success',
        );
        return response()->json($response);
    }
    public function topVolumeSparkline(Request $request)
    {

        // $today = '2023-01-19';
        // $trade_batch = 160;
        $today = $request->tdate;
        $trade_batch = $request->trade_batch;

        $topvolume = DataBanksIntraday::select('instrument_id', 'trade_date', 'yday_close_price', 'public_total_value', 'total_volume')
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - yday_close_price) * 100 ) / yday_close_price ELSE ((pub_last_traded_price - yday_close_price) * 100) / yday_close_price END AS pchange")
            ->where('batch', '=', $trade_batch)
            ->whereRaw("id in (select max(id) from data_banks_intradays where batch='$trade_batch' group by (instrument_id))")
            ->orderBy('total_volume', 'DESC')
            ->limit(10)
            ->get();

        $trade_date = $topvolume->isEmpty() ? null : $topvolume->first()->trade_date;
        // dd(['trade_date' => $trade_date]);

        // dd(DB::getQueryLog());

        foreach ($topvolume as $key => $row) {
            $single_row = $this->getSingleRow($row, $trade_date, $trade_batch);
            $topvolume[$key]['last_record'] = $single_row;
        }

        $response = array(
            'data' => array(
                'gainer' => $topvolume,
            ),
            'status' => 'success',
        );
        return response()->json($response);
    }

    public function topTradeSparkline(Request $request)
    {

        // $today = '2023-01-19';
        // $trade_batch = 160;
        $today = $request->tdate;
        $trade_batch = $request->trade_batch;


        //    DB::enableQueryLog();
        $gainer = DataBanksIntraday::select('instrument_id', 'trade_date', 'yday_close_price', 'public_total_value', 'total_trades')
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - yday_close_price) * 100 ) / yday_close_price ELSE ((pub_last_traded_price - yday_close_price) * 100) / yday_close_price END AS pchange")
            ->where('batch', '=', $trade_batch)
            ->whereRaw("id in (select max(id) from data_banks_intradays where batch='$trade_batch' group by (instrument_id))")

            ->orderBy('total_trades', 'DESC')
            ->limit(10)
            ->get();

        $trade_date = $gainer->isEmpty() ? null : $gainer->first()->trade_date;
        // dd(['trade_date' => $trade_date]);

        // dd(DB::getQueryLog());

        foreach ($gainer as $key => $row) {
            $single_row = $this->getSingleRow($row, $trade_date, $trade_batch);
            $gainer[$key]['last_record'] = $single_row;
        }

        $response = array(
            'data' => array(
                'gainer' => $gainer,
            ),
            'status' => 'success',
        );
        return response()->json($response);
    }
}
