<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MarketScheduler;
use App\Models\MarketScheduleSetting;

class UpdateScheduler extends Controller
{
    //
    public function Edit()
    { 
        $is_read =true;
        $marketsetting = MarketScheduleSetting::select('open_time','close_time')->orderBy('id','desc')->first();
        $fromDate = date('Y-m-d');
        return view('admin.market_scheduler.edit_scheduler')->with(['fromDate'=>$fromDate,'opentime'=>$marketsetting->open_time,'closetime'=>$marketsetting->close_time,'is_read'=>$is_read]);
    }

    public function EditData($id)

    { 
        $data=MarketScheduler::find($id);
        $isActivestatus=CommonController::Active();
        return view('admin.market_scheduler.edit_schedule_data')->with(['item'=>$data,'isActivestatus'=>$isActivestatus]);
    }



    public function Updatedata(Request $request,$id)
    {
        $data=MarketScheduler::find($id);
        $data->status = $request->status;
        $data->comments = $request->comments;
        $data->update();
        return redirect()->back()->with('status', 'Scheduler Data Update Successfully');
    }


    public function Update(Request $request)

    {
		
		$marketsetting = MarketScheduleSetting::select('open_time','close_time')->orderBy('id','desc')->first();
        $updatedata = [
            'open_time' => $marketsetting->open_time,
            'close_time' => $marketsetting->close_time
        ];
        MarketScheduler::where('open_date','>=', $request->open_date)
            ->update($updatedata);

        return redirect()->back()->with('status', 'Scheduler Update Successfully');
    }
}
