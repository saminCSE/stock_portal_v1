<?php

namespace App\Http\Controllers;

use App\Models\DataBanksEod;
use App\Models\Mkistat;
use App\Models\DataBanksIntraday;
use App\Models\IndexValue;
use App\Models\Instrument;
use App\Models\Market;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

class TradingViewController extends Controller
{

    public function __construct()
    {
       //
    }

    public function config(Request $request) {

        $response = [
            "supports_search"=>true,
            "supports_group_request"=>false,
            "supports_marks"=>true,
            "supports_timescale_marks"=>false,
            "supports_time"=>true,
            "exchanges"=>[
                    [   "value"=>"",
                        "name"=>"All Exchanges",
                        "desc"=>""
                    ],
                    [   "value"=>"DSE",
                        "name"=>"DSE",
                        "desc"=>"DSE"
                    ]

                ],
                "symbols_types"=>
                            [
                                [
                                    "name"=>"All Types",
                                    "value"=>""
                                ],
                                [
                                    "name"=>"Stock",
                                    "value"=>"stock"
                                ]
                            ],
                "supported_resolutions"=>["D","2D","3D","W","3W","M","6M","1Y","5Y"],
                "debug" => true
        ];

       return response()->json($response);
    }

    public function symbol_info_(Request $request) {

        $collections = Instrument::select('id','instrument_code','name')->orderBy('instrument_code','ASC')->where('active',1)->get();
        $response = [
            "symbol" =>  $collections->pluck('instrument_code'),
            "description" =>   $collections->pluck('name'),
            "exchange-listed" =>  "DSEX",
            "exchange-traded" =>  "DSEX",
            "minmovement" =>  1,
            "minmovement2" =>  0,
            "pricescale" =>  [1,10, 100],
            "has-dwm" =>  false,
            "has-intraday" =>  false,
            "visible-plots-set" =>  [true, true, true],
            "type" =>  "stock",
            "ticker" =>  $collections->pluck('instrument_code'),
            "timezone" =>  "Asia/Dhaka",
            "session-regular" =>  "0900-1430",
        ];
        return response()->json($response);
    }
    public function symbol_info(Request $request) {

        $collections = Instrument::select('id','instrument_code','name')->orderBy('instrument_code','ASC')->where('active',1)->get();
        $response = [
            "symbol" =>  $collections->pluck('instrument_code'),
            "description" =>   $collections->pluck('name'),
            "exchange-listed" =>  "DSEX",
            "exchange-traded" =>  "DSEX",
            "minmovement" =>  1,
            "minmovement2" =>  0,
            "pricescale" =>  [1,10, 100],
            "has-dwm" =>  false,
            "has-intraday" =>  false,
            "visible-plots-set" =>  [true, true, true],
            "type" =>  "stock",
            "ticker" =>  $collections->pluck('instrument_code'),
            "timezone" =>  "Asia/Dhaka",
            "session-regular" =>  "0900-1430",
        ];
        return response()->json($response);
    }
    public function search(Request $request) {

        $q = $request->get('query');
        $limit = $request->limit;
        $type = $request->type;

        if($q) {
           
        //   DB::enableQueryLog();
            $collections = Instrument::select('id','instrument_code','name')
            ->where('instrument_code','LIKE','%'.$q.'%')
            ->orWhere('name','LIKE','%'.$q.'%')
            ->limit($limit)
            ->orderBy('name','ASC')
            ->get();
          //  dd(DB::getQueryLog());
          //  dd(DB::getQueryLog());
           // return response()->json(DB::getQueryLog());
        }
        else {
          //  echo 555;exit;
            $collections = Instrument::select('id','instrument_code','name')->limit(30)->orderBy('name','ASC')->where('active',1)->get();
        }


        $response = [];

        foreach ($collections as $key=>$row) {

            $response[] = array(
                "symbol" => $row->instrument_code,
                "full_name" => $row->name,
                "description" => $row->name,
                "exchange" => 'DSE',
                "type" => 'stock',
                "ticker" => $row->instrument_code,
            );
        }

        return response()->json($response);


        // $response = [
        //     [
        //         "symbol" => 'AAPL',
        //         "full_name" => 'AAPL 1 full name',
        //         "description" => 'AAPL description',
        //         "exchange" => 'DSEX',
        //         "type" => 'stock',
        //     ],
        //     [
        //         "symbol" => 'AAPL 2',
        //         "full_name" => 'AAPL 1 full name',
        //         "description" => 'AAPL description',
        //         "exchange" => 'DSEX',
        //         "type" => 'stock',
        //     ]
        // ];
        //return response()->json($response);
    }
    public function history(Request $request) {

    //    DB::enableQueryLog();
        $symbol = $request->symbol;
       // $resolution = $request->resolution;
        $from = $request->from;
        $to = $request->to;
        //$countback = $request->countback;

    //    echo $from_c = Carbon::parse($from)->format('d-m-y H:i:s');
         $from_c = date('Y-m-d',$from);
      
         $to_c = date('Y-m-d',$to);


        $getSymbol = Instrument::where('instrument_code',$symbol)->first();


        $collections = DataBanksEod::select('*',DB::raw('UNIX_TIMESTAMP(date) as unix_lm_date_time'))
                       ->where('date','>=',$from_c)
                       ->where('date','<=',$to_c)
                       ->where('instrument_id',$getSymbol->id)
                       ->get();
                       
           
            if ($collections->count()) {

                // dd(DB::getQueryLog());
                $response = [
                    "t" =>$collections->pluck('unix_lm_date_time'),
                    "o"=>$collections->pluck('open'),
                    "h"=>$collections->pluck('high'),
                    "l"=>$collections->pluck('low'),
                    "c"=>$collections->pluck('close'),
                    "v"=>$collections->pluck('volume'),
                    "s"=>"ok",
                    "nextTime"=>true,
                    ];
                return response()->json($response);
            }
            else {
                $response = array(
                    "s" => "no_data",
                    "nextTime" => false
                );
                return response()->json($response);
            }

    }
    public function getFromIntraDayhistory(Request $request) {

      //  DB::enableQueryLog();
        $symbol = $request->symbol;
       // $resolution = $request->resolution;
        $from = $request->from;
        $to = $request->to;
        //$countback = $request->countback;

    //    echo $from_c = Carbon::parse($from)->format('d-m-y H:i:s');
        $from_c = date('Y-m-d',$from);
        $to_c = date('Y-m-d',$to);


        $getSymbol = Instrument::where('instrument_code',$symbol)->first();


        $collections = DataBanksIntraday::select('*',DB::raw('UNIX_TIMESTAMP(lm_date_time) as unix_lm_date_time'))
                       ->where('trade_date','>=',$from_c)
                       ->where('trade_date','<=',$to_c)
                       ->where('instrument_id',$getSymbol->id)
                       ->get();

            if ($collections->count()) {

                //dd(DB::getQueryLog());
                $response = [
                    "t" =>$collections->pluck('unix_lm_date_time'),
                    "o"=>$collections->pluck('open_price'),
                    "h"=>$collections->pluck('high_price'),
                    "l"=>$collections->pluck('low_price'),
                    "c"=>$collections->pluck('close_price'),
                    "v"=>$collections->pluck('total_volume'),
                    "s"=>"ok"
                    ];
                return response()->json($response);
            }
            else {
                $response = array(
                    "s" => "no_data",
                    "nextTime" => ''
                );
                return response()->json($response);
            }


    }
    public function marks(Request $request) {

        $response = [
			"id"=>[0,1,2,3,4,5],
			"time"=>[1522108800,1521763200,1521504000,1521504000,1520812800,1519516800],
			"color"=>["red","blue","green","red","blue","green"],
			"text"=>["Red","Blue","Green + Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.","Red again","Blue","Green"],
			"label"=>["A","B","CORE","D","EURO","F"],
			"labelFontColor"=>["white","white","red","#FFFFFF","white","#000"],
			"minSize"=>[14,28,7,40,7,14]
		];
        return response()->json($response);
    }
    public function timescale_marks(Request $request) {

        $response = [
			[
				"id"=>"tsm1","time"=>1522108800,"color"=>"red","label"=>"A","tooltip"=>""],
				["id"=>"tsm2","time"=>1521763200,"color"=>"blue","label"=>"D","tooltip"=>["Dividends=> $0.56","Date=> Fri Mar 23 2018"]],
				["id"=>"tsm3","time"=>1521504000,"color"=>"green","label"=>"D","tooltip"=>["Dividends=> $3.46","Date=> Tue Mar 20 2018"]],
				["id"=>"tsm4","time"=>1520812800,"color"=>"red","label"=>"E","tooltip"=>["Earnings=> $3.44","Estimate=> $3.60"],"shape"=>"earningDown"],
				["id"=>"tsm7","time"=>1519516800,"color"=>"green","label"=>"E","tooltip"=>["Earnings=> $5.40","Estimate=> $5.00"],"shape"=>"earningUp"],
				["id"=>"tsm8","time"=>1519516800,"color"=>"orange","label"=>"S","tooltip"=>["Split=> 4/1","Date=> Sun Feb 25 2018"]]
		];
        return response()->json($response);
    }
    public function symbols(Request $request) {

        $symboldata = Instrument::where("instrument_code",$request->symbol)->first();
        $response = [
            "symbol" =>  $symboldata->instrument_code,
            "name" =>   $symboldata->instrument_code,
            "ticker" =>   $symboldata->instrument_code,
            "description" =>   $symboldata->name,
            "type" =>   "stock",
            "session" =>  "24x7",
            "exchange" =>  "DSE",
            "exchange_listed" =>  "DSEX",
            "exchange_traded" =>  "DSEX",
            "pricescale" =>  1000,
            "timezone" =>  "Asia/Almaty",
            "minmov" => 1,
            "minmov2" => 0,
            "fractional" => true,
            "has_intraday" => true,
            "supported_resolutions" => ["D","2D","3D","W","3W","M","6M","1Y","5Y"],
            "intraday_multipliers" => ["D","2D","3D","W","3W","M","6M","1Y","5Y"],
            "has_seconds" => true,
            "seconds_multipliers" => null,
            "has_daily" => true,
            "has_weekly_and_monthly" => true,
            "has_empty_bars" => false,
            "force_session_rebuild" => true,
            "has_no_volume" => true,
            "volume_precision" => 0,
            "data_status" => "streaming",
            "expired" => true,

            "sector" => "",
            "industry" => "",
            "currency_code" => "BDT",
            "pointvalue" => 1,

        ];
        return response()->json($response);
    }
    public function quotes(Request $request) {

        $response = [
            "s"=> "ok",
            "d"=> [
                [
                    "s" => "ok",
                    "n" => "NYSE=>AA",
                    "v" => [
                        "ch" => "+0.16",
                        "chp" => "0.98",
                        "short_name" => "AA",
                        "exchange" => "NYSE",
                        "description" => "Alcoa Inc. Common",
                        "lp" => "16.57",
                        "ask" => "16.58",
                        "bid" => "16.57",
                        "open_price" => "16.25",
                        "high_price" => "16.60",
                        "low_price" => "16.25",
                        "prev_close_price" => "16.41",
                        "volume" => "4029041"
                    ]
                ],
                [
                    "s" => "ok",
                    "n" => "NYSE=>F",
                    "v" => [
                        "ch" => "+0.15",
                        "chp" => "0.89",
                        "short_name" => "F",
                        "exchange" => "NYSE",
                        "description" => "Ford Motor Company",
                        "lp" => "17.02",
                        "ask" => "17.03",
                        "bid" => "17.02",
                        "open_price" => "16.74",
                        "high_price" => "17.08",
                        "low_price" => "16.74",
                        "prev_close_price" => "16.87",
                        "volume" => "7713782"
                    ]
                ]
            ]
        ];
        return response()->json($response);
    }


   public function time() {
    return response()->json(time());
   }




  public function indexChart(Request $request) {

    //  DB::enableQueryLog();
      $instrument_id = $request->instrument_id;
      $last_id = $request->last_id;
      $from_c = $request->tdate;
      $to_c = $request->tdate;

    //   $from_c = '2021-11-15';//date('Y-m-d');
    //   $to_c = '2021-11-15';//date('Y-m-d');

    //SELECT * FROM `index_values` WHERE date(date_time) = '2021-11-15' ORDER BY date_time ASC
      $collections = IndexValue::select('id','date_time','capital_value',DB::raw('UNIX_TIMESTAMP(date_time) * 1000  as unix_date_time'))
                        ->whereRaw(
                            "(date(date_time) >= ? AND date(date_time) <= ?)",
                            [
                            $from_c,
                            $to_c
                            ]
                         )
                        ->where('instrument_id','=',$instrument_id);


            if($last_id) {
                $collections = $collections->where('id','>',$last_id);
            }

            $collections  =  $collections->orderBy('id','ASC')->get();


          if ($collections->count()) {
              return response()->json($collections);
          }
          else {
              $response = [];
              return response()->json($response);
          }

  }


   public function tradeValue(Request $request) {

    //  DB::enableQueryLog();
      $instrument_id = $request->instrument_id;
      $last_id = $request->last_id;

      $from_c = $request->tdate;
      $to_c = $request->tdate;

    //   $from_c = '2021-11-15';//date('Y-m-d');
    //   $to_c = '2021-11-15';//date('Y-m-d');

      $collections = IndexValue::select('*',DB::raw('UNIX_TIMESTAMP(date_time) as unix_date_time'))
                        ->whereRaw(
                            "(date(date_time) >= ? AND date(date_time) <= ?)",
                            [
                            $from_c,
                            $to_c
                            ]
                         )
                        ->where('instrument_id','=',$instrument_id);


            if($last_id) {
                $collections = $collections->where('id','>',$last_id);
            }

            $collections  =  $collections->orderBy('id','ASC')->take(20)->get();
        // dd(DB::getQueryLog());


          if ($collections->count()) {
              return response()->json($collections);
          }
          else {
              $response = [];
              return response()->json($response);
          }
  }

    public function todayTradeStatistics(Request $request) {
//   DB::enableQueryLog();
            $today = $request->tdate;
            $collections = DataBanksEod::selectRaw("SUM(CASE WHEN open > ycp THEN 1 ELSE 0 END) as up")
                            ->selectRaw("SUM(CASE WHEN open < ycp THEN 1 ELSE 0 END) as down")
                            ->selectRaw("SUM(CASE WHEN open = ycp THEN 1 ELSE 0 END) as flat")
                            ->where('date','=',$today)
                            ->first();
                            //    dd(DB::getQueryLog());
            return response()->json($collections);

    }

    public function tenDaysTradeStatistics() {
        //   DB::enableQueryLog();
            $collections = Market::select('trade_date','trd_total_volume as volume','trd_total_value as value','trd_total_capital as capital','percentage_deviation as pdeviation')
                            ->groupBy('trade_date')
                            ->orderBy('trade_date','DESC')
                            ->orderBy('id','DESC')
                            ->limit(10)
                            ->get();
            //  dd(DB::getQueryLog());
            // dd($collections);
            return response()->json($collections);
    }
    public function indexMoversPullers(Request $request) {
        //   DB::enableQueryLog();

        $today = $request->tdate;
        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','yday_close_price')
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - yday_close_price) * 100 ) / yday_close_price ELSE ((pub_last_traded_price - yday_close_price) * 100) / yday_close_price END AS pchange")
                           ->where('trade_date','=',$today)
                            ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
                            ->whereRaw("(CASE  WHEN pub_last_traded_price = 0 THEN spot_last_traded_price > yday_close_price ELSE pub_last_traded_price > yday_close_price END)")
                            ->orderBy('pchange','DESC')
                            ->limit(10)
                            ->get();
        //  dd(DB::getQueryLog());
        // dd($collections);
        return response()->json($collections);

    }
    public function indexMoversDraggers(Request $request) {
        //   DB::enableQueryLog();
        $today = $request->tdate;
        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','yday_close_price')
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - yday_close_price) * 100 ) / yday_close_price ELSE ((pub_last_traded_price - yday_close_price) * 100) / yday_close_price END AS pchange")
                           ->where('trade_date','=',$today)
                           ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
                            ->whereRaw("(CASE  WHEN pub_last_traded_price = 0 THEN spot_last_traded_price < yday_close_price ELSE pub_last_traded_price < yday_close_price END)")
                            ->orderBy('pchange','DESC')
                            ->limit(10)
                            ->get();
        //  dd(DB::getQueryLog());
        // dd($collections);
        return response()->json($collections);
    }

    public function sectorTotalValues(Request $request) {
        //   DB::enableQueryLog();
        $today = $request->tdate;
        // $collections = DataBanksEod::select("sector.name","data_banks_eods.instrument_id","data_banks_eods.sector_id")
        //                 ->selectRaw("sum(data_banks_eods.volume) as value")
        //                 ->leftJoin('sector', 'data_banks_eods.sector_id', '=', 'sector.id')
        //                 ->groupBy('data_banks_eods.sector_id')
        //                 ->where('data_banks_eods.date','=','2007-01-03')
        //                 ->where('data_banks_eods.sector_id','!=',0)
        //                 ->where('sector.is_active','=',1)
        //                 ->get();

        $collections = Sector::select("sector.name")
                        ->selectRaw("sum(data_banks_eods.volume) as value")
                        ->leftJoin('data_banks_eods', 'data_banks_eods.sector_id', '=', 'sector.id')
                        ->groupBy('data_banks_eods.sector_id')
                        ->where('data_banks_eods.date','=',$today)
                        ->where('data_banks_eods.sector_id','!=',0)
                        ->where('sector.is_active','=',1)
                        ->get();
        //  dd(DB::getQueryLog());
        // dd($collections);

        $response = array(
            'data'=>$collections,
            'cdate'=>changeDateFormate($today,'d-m-Y')
        );

        return response()->json($response);
    }

    public function sectorUpDown(Request $request) {
        //   DB::enableQueryLog();
        $today = $request->tdate;

        $collections = Sector::select("sector.name")
                        ->selectRaw("SUM(CASE WHEN data_banks_eods.open > data_banks_eods.ycp THEN 1 ELSE 0 END) as up")
                        ->selectRaw("SUM(CASE WHEN data_banks_eods.open < data_banks_eods.ycp THEN 1 ELSE 0 END) as down")
                        ->selectRaw("SUM(CASE WHEN data_banks_eods.open = data_banks_eods.ycp THEN 1 ELSE 0 END) as flat")
                        ->leftJoin('data_banks_eods', 'data_banks_eods.sector_id', '=', 'sector.id')
                        ->groupBy('data_banks_eods.sector_id')
                        ->where('data_banks_eods.date','=',$today)
                        ->where('data_banks_eods.sector_id','!=',0)
                        ->where('sector.is_active','=',1)
                        ->get();
        //  dd(DB::getQueryLog());
        // dd($collections);

        $response = array(
            'data'=>$collections,
            'status'=>'success',
            'cdate'=>changeDateFormate($today,'d-m-Y')
        );

        return response()->json($response);
    }

}
