<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\ContestVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CommonController;
use App\Http\Requests\ContestVideoRequest;

class ContestVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contestVideos = DB::table('contest_videos')
        ->join('contests','contests.id','contest_videos.contests_id')
        ->orderBy('contest_videos.id','DESC')
        ->select('contests.title AS contest_title','contest_videos.*')
        ->get();
        return view('admin.demo_trade.contest_video.index',compact('contestVideos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_active=CommonController::IsActive();
        $contest = Contest::orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Common Contest', '0');
        return view('admin.demo_trade.contest_video.form',compact('is_active','contest'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContestVideoRequest $request)
    {
        ContestVideo::create($request->all());
        Session::flash('message', 'New Contest Video Added Successfully');
        return redirect()->route('contest_video.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContestVideo  $contestVideo
     * @return \Illuminate\Http\Response
     */
    public function show(ContestVideo $contestVideo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContestVideo  $contestVideo
     * @return \Illuminate\Http\Response
     */
    public function edit(ContestVideo $contestVideo)
    {
        $is_active=CommonController::IsActive();
        $contest = Contest::orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Common Contest', '0');
        return view('admin.demo_trade.contest_video.form')->with(['item'=>$contestVideo,'is_active'=>$is_active,'contest'=>$contest]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContestVideo  $contestVideo
     * @return \Illuminate\Http\Response
     */
    public function update(ContestVideoRequest $request, ContestVideo $contestVideo)
    {
        $contestVideo->update($request->all());
        Session::flash('message', 'Contest video update successfully');
        return redirect()->route('contest_video.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContestVideo  $contestVideo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContestVideo $contestVideo)
    {
        $contestVideo->delete();
        return redirect()->back()->with('status', 'Contest video delete successfully');
    }
}
