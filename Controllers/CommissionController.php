<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\CommissionRequest;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commissions = DB::table('commissions')
        ->orderBy('commissions.id','DESC')
        ->get();
        return view('admin.demo_trade.commission.index',compact('commissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_active=CommonController::IsActive();
        $charges=CommonController::Charge();
        return view('admin.demo_trade.commission.form',compact('is_active','charges'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommissionRequest $request)
    {
        Commission::create($request->all());
        Session::flash('message', 'New Commission Create Successfully');
        return redirect()->route('commission.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        $is_active=CommonController::IsActive();
        $charges=CommonController::Charge();
        return view('admin.demo_trade.commission.form')->with(['item'=>$commission,'is_active'=>$is_active,'charges'=>$charges]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(CommissionRequest $request, Commission $commission)
    {
        $commission->update($request->all());
        return redirect()->route('commission.index')->with('status', 'Commission Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        $commission->delete();
        return redirect()->back()->with('status', 'commission Delete Successfully');
    }
}
