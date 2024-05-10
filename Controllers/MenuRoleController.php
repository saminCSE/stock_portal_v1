<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use App\Http\Requests\MenuRoleRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class MenuRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = RoleMenu::with('menu','role')->orderBy('id','DESC')
            ->groupBy('role_id')
            ->get();
       
        // dd($collections);
        return View('admin.menu_role.index', [
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
        $menu = Menu::where(['is_active'=>1,'parent_id'=>'0'])->orderBY('menu_name', 'asc')->get();
       
        foreach($menu as $key=>$val) {
            $submenu = Menu::where(['is_active'=>1,'parent_id'=>$val->id])->orderBY('menu_name', 'asc')->get();
            $menu[$key]['submenu'] = $submenu;
        }
        $role = Role::where(['active_status'=>1])->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Role', '');
        
        // dd($rolemenu);exit;

        return view('admin.menu_role.form',compact('isActivestatus','menu','role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRoleRequest $request)
    {
        
       $menu_id = $request->menu_id;
       
        if(!$menu_id) {
            Session::flash('error', 'Sorry, You must be selected any menu.');
            return back()->withInput($request->all());
        }

        $roleid = $request->role_id;
        $menu_id = $request->menu_id;
        // dd($menu_id);
        $menu = array();
        foreach($menu_id as $key=>$val) {
            if(isset($val['menu'])) {
                $menu[] = $val['menu'];
            }
            if(isset($val['submenu'])) {
                foreach($val['submenu']  as $key=>$val) {
                    $menu[] = $key;
                }
            }
           
        }

        foreach($menu as $key=>$val){

            $existed = RoleMenu::where(['role_id'=>$roleid,'menu_id'=>$val])->first();

            if(!$existed) {
                $roleadd = array(
                    'role_id'=>$roleid,
                    'menu_id'=>$val,
                );
                $rolemenu = RoleMenu::create($roleadd);
            }            
        }

       
        Session::flash('message', Lang::get('messages.save_success'));
        return redirect()->route('rolemenu.index');
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
    public function edit($id)
    {

        $existed = RoleMenu::where(['role_id'=>$id])->first();

        if(!$existed) {
            Session::flash('error', 'Sorry, You can not access this information.');
            return back()->withInput($request->all());
        }

        $isActivestatus = CommonController::enableDisable();
        $menu = Menu::where(['is_active'=>1,'parent_id'=>'0'])->orderBY('menu_name', 'asc')->get();
       
        foreach($menu as $key=>$val) {
            $submenu = Menu::where(['is_active'=>1,'parent_id'=>$val->id])->orderBY('menu_name', 'asc')->get();
            $menu[$key]['submenu'] = $submenu;
        }

        $role = Role::where(['active_status'=>1])->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Role', '');
        
        $item = RoleMenu::where('role_id',$id)->get();

    
        foreach($menu as $key=>$val) {
            
          

            $menu[$key]['is_selected'] = 0;
            $menuexisted = RoleMenu::where(['role_id'=>$id,'menu_id'=>$val->id])->first();
           
            if($menuexisted) {
                $menu[$key]['is_selected'] = 1;               
            }

            foreach($val['submenu'] as $skey=>$sval) {

               
                $menu[$key]['submenu'][$skey]['is_selected'] = 0;
                $menuexisted = RoleMenu::where(['role_id'=>$id,'menu_id'=>$sval->id])->first();
            
                if($menuexisted) {
                    $menu[$key]['submenu'][$skey]['is_selected'] = 1;               
                }
            }
        }

        // print_r($menu);
        
        return view('admin.menu_role.edit')->with(['item'=>$item,'isActivestatus'=>$isActivestatus,'menu'=>$menu,'role'=>$role,'id'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $menu_id = $request->menu_id;
       
        if(!$menu_id) {
            Session::flash('error', 'Sorry, You must be selected any menu.');
            return back()->withInput($request->all());
        }

        $roleid = $request->roleid;
        $menu_id = $request->menu_id;
       
        $menu = array();
        foreach($menu_id as $key=>$val) {
            if(isset($val['menu'])) {
                $menu[] = $val['menu'];
            }
            
            if(isset($val['submenu'])) {
                foreach($val['submenu']  as $key=>$val) {
                    $menu[] = $key;
                }
            }
           
        }

        RoleMenu::where('role_id',$id)->delete();

        foreach($menu as $key=>$val){

            $existed = RoleMenu::where(['role_id'=>$roleid,'menu_id'=>$val])->first();

            if(!$existed) {
                $roleadd = array(
                    'role_id'=>$roleid,
                    'menu_id'=>$val,
                );
                $rolemenu = RoleMenu::create($roleadd);
            }            
        }


        Session::flash('message', Lang::get('messages.Updated successfully'));
        return redirect()->route('rolemenu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
      
        //$rolemenu->delete();
        RoleMenu::where('role_id',$id)->delete();

        Session::flash('message', Lang::get('messages.Deleted successfully'));
        return redirect()->route('rolemenu.index');
    }

    public function menuroleadd(Request $request) 
    {
        $isActivestatus = CommonController::enableDisable();
        $parent_menu = Menu::where(['is_active'=>1,'parent_id'=>'0'])->orderBY('menu_name', 'asc')->get()->pluck('menu_name', 'id')->prepend('Select Menu', '0');
        
        return view('admin.menu_role.form',compact('isActivestatus','parent_menu'));
    }

    

}
