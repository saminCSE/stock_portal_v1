<?php

namespace App\Http\Controllers;


use App\Models\Contest;
use Illuminate\Http\Request;
use App\Models\ContestOrganizer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ContestOrganizerRequest;

class ContestOrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contestOrganizers = DB::table('contest_organizers')
        ->join('contests','contests.id','contest_organizers.contest_id')
        ->orderBy('contest_organizers.id','DESC')
        ->select('contests.title AS contest_title','contest_organizers.*')
        // ->limit(10)
        ->get();
        return view('admin.demo_trade.contest_organizer.index',compact('contestOrganizers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_active=CommonController::IsActive();
        $contest = Contest::orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Contest', '');
        return view('admin.demo_trade.contest_organizer.form',compact('is_active','contest'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContestOrganizerRequest $request)
    {
        ContestOrganizer::create($request->all());
        Session::flash('message', 'New Contest Organizer Create Successfully');
        return redirect()->route('contest_organizer.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContestOrganizer  $contestOrganizer
     * @return \Illuminate\Http\Response
     */
    public function show(ContestOrganizer $contestOrganizer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContestOrganizer  $contestOrganizer
     * @return \Illuminate\Http\Response
     */
    public function edit(ContestOrganizer $contestOrganizer)
    {
        $is_active=CommonController::IsActive();
        $contest = Contest::orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Contest', '');
        return view('admin.demo_trade.contest_organizer.form')->with(['item'=>$contestOrganizer,'is_active'=>$is_active,'contest'=>$contest]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContestOrganizer  $contestOrganizer
     * @return \Illuminate\Http\Response
     */
    public function update(ContestOrganizerRequest $request, ContestOrganizer $contestOrganizer)
    {
        $contestOrganizer->update($request->all());
        Session::flash('message', 'Contest organizer update successfully');
        return redirect()->route('contest_organizer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContestOrganizer  $contestOrganizer
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContestOrganizer $contestOrganizer)
    {
        $contestOrganizer->delete();
        return redirect()->back()->with('status', 'Contest organizer delete successfully');
    }
}
