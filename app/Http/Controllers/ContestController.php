<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\ContestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ContestRequest;
use Illuminate\Support\Facades\Session;

class ContestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contests = DB::table('contests')
        ->join('contest_types','contest_types.id','contests.contest_type_id')
        ->orderBy('contests.id','DESC')
        ->select('contest_types.title AS contest_type_title','contests.*')
        // ->limit(10)
        ->get();
        return view('admin.demo_trade.contest.index',compact('contests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_active=CommonController::IsActive();
        $contestStatus=CommonController::ContestStatus();
        $contestType = ContestType::orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Contest Type', '');
        return view('admin.demo_trade.contest.form',compact('is_active','contestStatus','contestType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContestRequest $request)
    {
        Contest::create($request->all());
        Session::flash('message', 'New Contest Create Successfully');
        return redirect()->route('contest.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function show(Contest $contest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest)
    {
        $is_active=CommonController::IsActive();
        $contestStatus=CommonController::ContestStatus();
        $contestType = ContestType::orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Contest Type', '');
        return view('admin.demo_trade.contest.form')->with(['item'=>$contest,'is_active'=>$is_active,'contestType'=>$contestType,'contestStatus'=>$contestStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function update(ContestRequest $request, Contest $contest)
    {
        $contest->update($request->all());
        Session::flash('message', 'Contest update successfully');
        return redirect()->route('contest.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contest $contest)
    {
        $contest->delete();
        return redirect()->back()->with('status', 'Contest delete successfully');
    }
}
