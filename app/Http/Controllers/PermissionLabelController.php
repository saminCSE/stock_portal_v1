<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Permissionmod;
use App\Http\Requests\PermissionRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class PermissionLabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = Permissionmod::orderBy('id','DESC')->get();
       
        // dd($collections);
        return View('admin.permissionlabel.index', [
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
        
        return view('admin.permissionlabel.form',compact('isActivestatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
       $data = $request->all();
       $data['guard_name'] = 'web';
        $permissionlabel = Permissionmod::create($data);
        Session::flash('message', Lang::get('messages.save_success'));
        return redirect()->route('permissionlabel.index');
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
    public function edit(Permissionmod $permissionlabel)
    {
        // $permissionlabel = Menu::find($id);
        $isActivestatus = CommonController::enableDisable();
       
       
        return view('admin.permissionlabel.form')->with(['item'=>$permissionlabel,'isActivestatus'=>$isActivestatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request,Permissionmod $permissionlabel)
    {
        $permissionlabel->update($request->all());
        Session::flash('message', Lang::get('messages.Updated successfully'));
        return redirect()->route('permissionlabel.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permissionmod $permissionlabel)
    {
        $permissionlabel->delete();
        Session::flash('message', Lang::get('messages.Deleted successfully'));
        return redirect()->route('permissionlabel.index');
    }

  

    

}
