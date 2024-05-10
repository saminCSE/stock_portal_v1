<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketScheduler;
use App\Models\MarketScheduleSetting;

class MarketSchedulerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections  = MarketScheduler::orderBy('open_date','DESC')->get();
        return view('admin.market_scheduler.index',compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $day = CommonController::Day();
        $isActivestatus=CommonController::Active();
        $market=MarketScheduleSetting::find($id);
        return view('admin.market_scheduler.edit')->with(['item'=>$market,'day'=>$day,'isActivestatus'=>$isActivestatus]);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $register=MarketScheduleSetting::find($id);
        $register->trading_open_day = $request->trading_open_day;
        $register->open_time = $request->open_time;
        $register->close_time = $request->close_time;
        $register->trading_close_day = $request->trading_close_day;
        $register->status = $request->status;
        $register->comments = $request->comments;
        $register->update();
        return redirect()->back()->with('status', 'Scheduler Settings Update Successfully');
    }


   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
