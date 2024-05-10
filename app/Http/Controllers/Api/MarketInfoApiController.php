<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Models\Market;
use App\Models\MarketScheduler;
use App\Models\MarketScheduleSetting;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketInfoApiController extends Controller
{
    public function ShowMarketInfo(){
            // DB::enableQueryLog();
        $marketInfos = Market::select('id as market_id','data_bank_intraday_batch as trade_batch','eod_last_trade_id as eod_last_id','intraday_last_trade_id as intraday_last_id','trade_date AS open_date','market_started AS open_time','market_closed AS close_time')
                // ->where('trade_date', '2011-06-15')
                ->orderBy('trade_date', 'DESC')
                ->first();
        
        $today = date('Y-m-d');
        $currnet_time = date('H:i:s');

        $marketScheduler = MarketScheduleSetting::select('open_time','close_time')->first();
        
        $response_two = array('market_status'=>0);


        if( $currnet_time < $marketScheduler->open_time ) {
           
            $marketOpening = MarketScheduler::select('open_date','open_time','close_time')->where('open_date','>=',$today)->where('status','=',1)->first();
        }
        else if($currnet_time > $marketScheduler->close_time ) {
           
            $marketOpening = MarketScheduler::select('open_date','open_time','close_time')->where('open_date','>',$today)->where('status','=',1)->first();
        }
        else if($currnet_time > $marketScheduler->open_time &&  $currnet_time < $marketScheduler->close_time) {
          
            $marketOpening = MarketScheduler::select('open_date','open_time','close_time')->where('open_date','>=',$today)->where('status','=',1)->first();
            if($marketOpening && $marketOpening->open_date == $today) {
                $response_two['market_status'] = 1;
            }
        }
        else {
           
            $marketOpening = MarketScheduler::select('open_date','open_time','close_time')->orderBy('id', 'DESC')->where('open_date','=',$today)->first();
            $response_two['market_status'] = 1;
        }
        
        $response_two['market_schedule'] = $marketOpening;

        $instrument = Instrument::select("id","instrument_code","isin","name")->pluck('instrument_code','id')->toArray();

//  dd(DB::getQueryLog());
        try {
            $response = array(
                'data'=>$marketInfos,
                'schedule'=>$response_two,
                'instrument'=>$instrument,
                'status'=>'success',
            );
            return response()->json($response);
           } catch (HttpException $e) {
               return response()->json(['error' => $e->getMessage()], 500);
           }
    }
    
}
