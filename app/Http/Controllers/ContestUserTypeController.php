<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContestUserType;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ContestUserTypeRequest;

class ContestUserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contestUserTypes = ContestUserType::orderBy('id')->get();
        return view('admin.demo_trade.contest_user_type.index',compact('contestUserTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_active=CommonController::IsActive();
        return view('admin.demo_trade.contest_user_type.form',compact('is_active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContestUserTypeRequest $request)
    {
        ContestUserType::create($request->all());
        Session::flash('message', 'New Contest User Type Create Successfully');
        return redirect()->route('contest_user_type.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContestUserType  $contestUserType
     * @return \Illuminate\Http\Response
     */
    public function show(ContestUserType $contestUserType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContestUserType  $contestUserType
     * @return \Illuminate\Http\Response
     */
    public function edit(ContestUserType $contestUserType)
    {
        $is_active=CommonController::IsActive();
    
        return view('admin.demo_trade.contest_user_type.form')->with(['item'=>$contestUserType,'is_active'=>$is_active]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContestUserType  $contestUserType
     * @return \Illuminate\Http\Response
     */
    public function update(ContestUserTypeRequest $request, ContestUserType $contestUserType)
    {
        $contestUserType->update($request->all());
        Session::flash('message', 'Contest User Type update Successfully');
        return redirect()->route('contest_user_type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContestUserType  $contestUserType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContestUserType $contestUserType)
    {
        $contestUserType->delete();
        return redirect()->back()->with('status', 'Contest User Type Delete Successfully');
    }
}
