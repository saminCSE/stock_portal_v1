<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesignationRequest;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designations = Designation::all();
        return view('admin.designation.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isActivestatus = CommonController::enableDisable();
        return view('admin.designation.form',compact('isActivestatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesignationRequest $request)
    {
        Designation::create($request->all());
        Session::flash('message', 'New Designation Create Successfully');
        return redirect()->route('designation.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {
        $isActivestatus = CommonController::enableDisable();
        return view('admin.designation.form')->with(['item'=>$designation,'isActivestatus'=>$isActivestatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(DesignationRequest $request, Designation $designation)
    {
        $designation->update($request->all());
        return redirect()->route('designation.index')->with('status', 'Designation Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->back()->with('status', 'Designation Delete Successfully');
    }
}
