<?php

namespace App\Http\Controllers\Api;

use App\Models\Market;
use App\Models\IndexValue;
use Illuminate\Http\Request;
use App\Models\DataBanksIntraday;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Instrument;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TopGainerLoserController extends Controller
{
    public function topTenGainerConsideringOPAndLTP(Request $request){
        //This Value name is DEVIATION Lonka Bangla Using this way

        $today = $request->date;//date('Y-m-d');
        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','open_price')
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - open_price) * 100 ) / open_price ELSE ((pub_last_traded_price - open_price) * 100) / open_price END AS pchange")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price - open_price ELSE pub_last_traded_price - open_price END AS rchange")
            ->where('trade_date','=',$today)
            ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
            ->orderBy('pchange','DESC')
            ->limit(5)
//            ->toSql();
            ->get();
            $response = array(
                'data'=>$collections,
                'status'=>'success',
            );
            return response()->json($response);
    }

    public function topTenLoserConsideringOPAndLTP(Request $request){
        
        $today = $request->date;//date('Y-m-d');
        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','open_price')
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((open_price - spot_last_traded_price) * 100 ) / open_price ELSE ((open_price -pub_last_traded_price) * 100) / open_price END AS pchange")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN open_price - spot_last_traded_price ELSE open_price - pub_last_traded_price END AS rchange")
            ->where('trade_date','=',$today)
            ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
            ->orderBy('pchange','DESC')
            ->limit(5)
            ->get();

//        return response()->json($collections);

            $response = array(
                'data'=>$collections,
                'status'=>'success',
            );
            return response()->json($response);
    }

    public function tradingTickers(Request $request){

//        $today = date('Y-m-d');
        $today = $request->date;
//        dd($today);
        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','open_price')
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - open_price) * 100 ) / open_price ELSE ((pub_last_traded_price - open_price) * 100) / open_price END AS pchange")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price - open_price ELSE pub_last_traded_price - open_price  END AS rchange")
            ->where('trade_date','=',$today)
            ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
            ->orderBy('total_volume','DESC')
            ->limit(5)
//            ->toSql();
            ->get();
        $response = array(
            'data'=>$collections,
            'status'=>'success',
        );
        return response()->json($response);
    }
    public function recentViewSymbol(Request $request){

        $symbol_id = array_map('intval',explode(',',$request->symbol));

//        dd($symbol_id);
        $today = $request->date;

        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','open_price')
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - open_price) * 100 ) / open_price ELSE ((pub_last_traded_price - open_price) * 100) / open_price END AS pchange")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price - open_price ELSE pub_last_traded_price - open_price  END AS rchange")
            ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
            ->whereIn('instrument_id',$symbol_id)
            ->orderBy('total_volume','DESC')
            ->limit(5)
//            ->toSql();
            ->get();
//        return response()->json($collections);

            $response = array(
                'data'=>$collections,
                'status'=>'success',
            );
            return response()->json($response);
    }

    public function mostActive(Request $request){
        $today = $request->tdate;//date('Y-m-d');
        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','pub_last_traded_price','total_trades','total_volume')
            ->where('trade_date','=',$today)
            ->whereRaw("id in (select max(id) from data_banks_intradays group by (instrument_id))")
            ->orderBy('total_volume','DESC')
            ->limit(20)
            ->get();
            $response = array(
                'data'=>$collections,
                'status'=>'success',
            );
            return response()->json($response);
    }

    


    public function tradeValue(Request $request){

        if(!$request->tdate){
            return response()->json([
                'today' => (object) ['capital_value'=>0],
                'yesterday' => (object) ['capital_value'=>0],
                'weeklyAverage' => (object) ['weekly_average'=>0],
            ]);
        }
        $today = $request->tdate;//date('Y-m-d');
        //$today = '2021-12-06';//date('Y-m-d');
        $previousDay = date('Y-m-d', strtotime($today .' -1 day'));

        $tradeValueToday = Market::select('id','trade_date','trd_total_value as capital_value')
        ->where('trade_date','=',$today)
        ->orderBy('trade_date','DESC')
        ->limit(1)
        ->first();  

        $tradeValueYesterday = Market::select('id','trade_date','trd_total_value as capital_value')
        ->where('trade_date','<',$today)
        ->orderBy('trade_date','DESC')
        ->limit(1)
        ->first(); 

        $startDate = date('Y-m-d', strtotime($today .' -5 days'));
        $endDate = date('Y-m-d');

        $tradeValueWeeklyAverage = Market::select(DB::raw('AVG(trd_total_value) as weekly_average'))
            ->whereBetween('trade_date', [$startDate, $endDate])
            ->first();

            return response()->json([
                'today' => $tradeValueToday ? $tradeValueToday:(object) ['capital_value'=>0],
                'yesterday' => $tradeValueYesterday?$tradeValueYesterday:(object) ['capital_value'=>0],
                'weeklyAverage' => $tradeValueWeeklyAverage?$tradeValueWeeklyAverage:(object) ['weekly_average'=>0],
            ]);
    }

    public function StrengthMeter(Request $request) {
        $today = $request->tdate;
        $draggerCount = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','yday_close_price')
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - yday_close_price) * 100 ) / yday_close_price ELSE ((pub_last_traded_price - yday_close_price) * 100) / yday_close_price END AS pchange")
                           ->where('trade_date','=',$today)
                           ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
                            ->whereRaw("(CASE  WHEN pub_last_traded_price = 0 THEN spot_last_traded_price < yday_close_price ELSE pub_last_traded_price < yday_close_price END)")
                            ->orderBy('pchange','DESC')
                            ->get();
                            $draggerCount= $draggerCount->count();

         $pullerCount = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','yday_close_price')
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((spot_last_traded_price - yday_close_price) * 100 ) / yday_close_price ELSE ((pub_last_traded_price - yday_close_price) * 100) / yday_close_price END AS pchange")
                             ->where('trade_date','=',$today)
                            ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
                            ->whereRaw("(CASE  WHEN pub_last_traded_price = 0 THEN spot_last_traded_price > yday_close_price ELSE pub_last_traded_price > yday_close_price END)")
                            ->orderBy('pchange','DESC')
                            ->get();
                            $pullerCount = $pullerCount->count();

                            $totalInstrumentCount = Instrument:: where('active',1)
                            ->count();

                            $unchangedCount = $totalInstrumentCount - ($pullerCount + $draggerCount);

                            $response = array(
                               'data'=>array(
                                'puller_count'=>$pullerCount,
                                'dragger_count'=>$draggerCount,
                                'unchanged_count'=>$unchangedCount
                               ),
                               'status'=>'success',
                            );
                            return response()->json($response);
    }
}
