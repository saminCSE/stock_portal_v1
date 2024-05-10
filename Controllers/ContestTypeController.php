<?php

namespace App\Http\Controllers;

use App\Models\ContestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ContestTypeRequest;

class ContestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contestTypes = ContestType::orderBy('id')->get();
        return view('admin.demo_trade.contest_type.index',compact('contestTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_active=CommonController::IsActive();
        return view('admin.demo_trade.contest_type.form',compact('is_active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContestTypeRequest $request)
    {
        ContestType::create($request->all());
        Session::flash('message', 'New Contest Type Create Successfully');
        return redirect()->route('contest_type.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContestType  $contestType
     * @return \Illuminate\Http\Response
     */
    public function show(ContestType $contestType)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContestType  $contestType
     * @return \Illuminate\Http\Response
     */
    public function edit(ContestType $contestType)
    {
        $is_active=CommonController::IsActive();
        return view('admin.demo_trade.contest_type.form')->with(['item'=>$contestType,'is_active'=>$is_active]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContestType  $contestType
     * @return \Illuminate\Http\Response
     */
    public function update(ContestTypeRequest $request, ContestType $contestType)
    {
        $contestType->update($request->all());
        Session::flash('message', 'Contest type update successfully');
        return redirect()->route('contest_type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContestType  $contestType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContestType $contestType)
    {
        $contestType->delete();
        return redirect()->back()->with('status', 'Contest type delete successfully');
    }
}
