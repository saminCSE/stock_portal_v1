<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Requests\MenuRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = Menu::with('getParentMenu')->orderBy('id','DESC')->get();
       
        // dd($collections);
        return View('admin.menu.index', [
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
        $parent_menu = Menu::where(['is_active'=>1,'parent_id'=>'0'])->orderBY('menu_name', 'asc')->get()->pluck('menu_name', 'id')->prepend('Select Menu', '0');
        
        return view('admin.menu.form',compact('isActivestatus','parent_menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
       
        $menu = Menu::create($request->all());
        Session::flash('message', Lang::get('messages.save_success'));
        return redirect()->route('menu.index');
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
    public function edit(Menu $menu)
    {
        // $menu = Menu::find($id);
        $isActivestatus = CommonController::enableDisable();
        $parent_menu = Menu::where(['is_active'=>1,'parent_id'=>'0'])->orderBY('menu_name', 'asc')->get()->pluck('menu_name', 'id')->prepend('Select Menu', '0');
        
       
        return view('admin.menu.form')->with(['item'=>$menu,'isActivestatus'=>$isActivestatus,'parent_menu'=>$parent_menu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request,Menu $menu)
    {
        $menu->update($request->all());
        Session::flash('message', Lang::get('messages.Updated successfully'));
        return redirect()->route('menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        Session::flash('message', Lang::get('messages.Deleted successfully'));
        return redirect()->route('menu.index');
    }

    public function menuroleadd(Request $request) 
    {
        $isActivestatus = CommonController::enableDisable();
        $parent_menu = Menu::where(['is_active'=>1,'parent_id'=>'0'])->orderBY('menu_name', 'asc')->get()->pluck('menu_name', 'id')->prepend('Select Menu', '0');
        
        return view('admin.menu.form',compact('isActivestatus','parent_menu'));
    }

    

}
