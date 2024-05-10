<?php

namespace App\Http\Controllers\Api;
use App\Models\DataBanksIntraday;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketBulletingApiController extends Controller
{
    public function MarketBulleting(Request $request){
        
        $today = $request->tdate;
        // $today = date('Y-m-d');
        // dd($today);
        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','yday_close_price','open_price')
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((open_price - spot_last_traded_price) * 100 ) / open_price ELSE ((open_price - pub_last_traded_price) * 100) / open_price END AS pchange")
                            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN  open_price - spot_last_traded_price ELSE open_price - pub_last_traded_price END AS rchange")
                            ->where('trade_date','=',$today)
                            ->whereRaw("yday_close_price != open_price")
                            ->whereRaw("id in (select max(id) from data_banks_intradays where trade_date='$today' group by (instrument_id))")
                            // ->whereRaw("(CASE  WHEN pub_last_traded_price = 0 THEN spot_last_traded_price > open_price ELSE pub_last_traded_price > open_price END)")
                            //->orderBy('rchange','DESC')
                            ->inRandomOrder()
                            // ->limit(10)
                            ->get();

            $response = array(
                'data'=>$collections,
                'status'=>'success',
            );
            return response()->json($response);  
    }
}
