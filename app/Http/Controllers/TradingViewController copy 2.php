<?php

namespace App\Http\Controllers;

use App\Models\DataBanksEod;
use App\Models\Mkistat;
use App\Models\DataBanksIntraday;
use App\Models\Instrument;
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
                                ],
                                [
                                    "name"=>"Index",
                                    "value"=>"Index"
                                ]
                               
                            ],
                "supported_resolutions"=>["D","2D","3D","W","3W","M","6M"],
                "debug" => true
        ];

       return response()->json($response);
    }

    public function symbol_info(Request $request) {

        $collections = Instrument::select('id','instrument_code','name')->orderBy('name','ASC')->get();
        $response = [
            "symbol" =>  $collections->pluck('instrument_code'),
            "description" =>   $collections->pluck('name'),
            "exchange-listed" =>  "DSEX",
            "exchange-traded" =>  "DSEX",
            "minmovement" =>  1,
            "minmovement2" =>  0,
            "pricescale" =>  [1, 1, 100],
            "has-dwm" =>  false,
            "has-intraday" =>  false,
            "visible-plots-set" =>  [true, true, true],
            "type" =>  "stock",
            "ticker" =>  $collections->pluck('instrument_code'),
            "timezone" =>  "Asia/Dhaka",
            "session-regular" =>  "0900-1400",
        ];
        return response()->json($response);
    }
    public function search(Request $request) {
       
        $q = $request->get('query');
        $limit = $request->limit;
        $type = $request->type;
       
        if($q) {
           
          DB::enableQueryLog();
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
            $collections = Instrument::select('id','instrument_code','name')->limit(30)->orderBy('name','ASC')->get();
        }
        

        $response = [];

        foreach ($collections as $key=>$row) {

            $response[] = array(
                "symbol" => $row->instrument_code,
                "full_name" => $row->name,
                "description" => $row->name,
                "exchange" => 'DSEX',
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
        

        $collections = DataBanksEod::select('*',DB::raw('UNIX_TIMESTAMP(date) as unix_lm_date_time'))
                       ->where('date','>=',$from_c)
                       ->where('date','<=',$to_c)
                       ->where('instrument_id',$getSymbol->id)
                       ->get();

            if ($collections->count()) {
                
                //dd(DB::getQueryLog()); 
                $response = [
                    "t" =>$collections->pluck('unix_lm_date_time'),
                    "o"=>$collections->pluck('open'),
                    "h"=>$collections->pluck('high'),
                    "l"=>$collections->pluck('low'),
                    "c"=>$collections->pluck('close'),
                    "v"=>$collections->pluck('volume'),
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
        
        $response = [
            "name" => "1JANATAMF",
            "exchange-traded" => "1JANATAMF",
            "exchange-listed" => "1JANATAMF",
            "timezone" => "America/New_York",
            "minmov" => 1,
            "minmov2" => 0,
            "pointvalue" => 1,
            "session" =>"0930-1630",
            "has_intraday" => '',
            "has_no_volume" => '',
            "description" => "1JANATAMF Inc.",
            "type" => "stock",
            "supported_resolutions" => 
                [
                     "D",
                     "2D",
                     "3D",
                     "W",
                     "3W",
                     "M",
                     "6M"
                ],
        
            "pricescale" => 100,
            "ticker" => "1JANATAMF"
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
   
}
