<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use App\Http\Requests\OfficeRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;
class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        $collections = Office::all();
        return View('admin.office.index', [
            'collections' => $collections
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isActivestatus = CommonController::enableDisable();
        return view('admin.office.form',compact('isActivestatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfficeRequest $request)
    {
       
        $office = Office::create($request->all());
        Session::flash('message', Lang::get('messages.save_success'));
        return redirect()->route('office.index');

           
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
    public function edit(Office $office)
    {
        $isActivestatus = CommonController::enableDisable();
        return view('admin.office.form')->with(['item'=>$office,'isActivestatus'=>$isActivestatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OfficeRequest $request,Office $office)
    {
        $office->update($request->all());
        Session::flash('message', Lang::get('messages.Updated successfully'));
        return redirect()->route('office.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        $office->delete();
        Session::flash('message', Lang::get('messages.Deleted successfully'));
        return redirect()->route('office.index');
    }
}
