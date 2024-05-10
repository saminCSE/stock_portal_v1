<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PrizeRequest;
use Illuminate\Support\Facades\Session;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prizes = DB::table('prizes')
        ->join('contests','contests.id','prizes.contest_id')
        ->orderBy('prizes.id','DESC')
        ->select('contests.title AS contest_title','prizes.*')
        // ->limit(10)
        ->get();
        return view('admin.demo_trade.prize.index',compact('prizes'));
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
        return view('admin.demo_trade.prize.form',compact('is_active','contest'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrizeRequest $request)
    {
        Prize::create($request->all());
        Session::flash('message', 'New Contest Prize Create Successfully');
        return redirect()->route('prize.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prize  $prize
     * @return \Illuminate\Http\Response
     */
    public function show(Prize $prize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prize  $prize
     * @return \Illuminate\Http\Response
     */
    public function edit(Prize $prize)
    {
        $is_active=CommonController::IsActive();
        $contest = Contest::orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Contest', '');
        return view('admin.demo_trade.prize.form')->with(['item'=>$prize,'is_active'=>$is_active,'contest'=>$contest]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prize  $prize
     * @return \Illuminate\Http\Response
     */
    public function update(PrizeRequest $request, Prize $prize)
    {
        $prize->update($request->all());
        Session::flash('message', 'Contest Prize update successfully');
        return redirect()->route('prize.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prize  $prize
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prize $prize)
    {
        $prize->delete();
        return redirect()->back()->with('status', 'Contest prize delete successfully');
    }
}
