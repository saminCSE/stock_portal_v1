<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketScheduleSetting;
use App\Models\MarketScheduler;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;

class CronController extends Controller
{
 
    public function index() {
       echo 'Error';
    }
    
    public function marketDateScheduler(Request $request) {
      
        $collection = MarketScheduleSetting::orderBy('id','desc')->limit(1)->first();

        if($collection) {
            
            // $trading_open_day = $collection->trading_open_day;
            // $open_time = $collection->open_time;
            // $trading_close_day = $collection->trading_close_day;
            // $close_time = $collection->close_time;


            $from_date = date('Y-m-d');
            $to_date = dayAddWithDate($from_date,61);

            

           
            $begin = new DateTime($from_date);
            $end = new DateTime($to_date);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            foreach ($period as $dt) {
                
                $isDay = existedDayName($dt->format("D"));

                if($isDay) {

                    $isExisted = MarketScheduler::where('open_date',$dt->format("Y-m-d"))->first();
                    if(!$isExisted) {
                    $insertData = [
                        'open_date'=>$dt->format("Y-m-d"),
                        'open_time'=>$collection->open_time,
                        'close_time'=>$collection->close_time,
                    ];

                    $status = MarketScheduler::create($insertData);
                    }
                }

               
            }

            //echo json_encode(array($from_date,$to_date));
            
            return 'Data added successfully completed';

        }
        
        
        
    }
  
   
    
}
