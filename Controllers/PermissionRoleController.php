<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use App\Models\roleHasPermission;
use App\Models\Permissionmod;
use App\Http\Requests\RolePermissionRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class PermissionRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = roleHasPermission::with('permission','role')->orderBy('role_id','ASC')
            ->groupBy('role_id')
            ->get();
       
        // dd($collections);
        return View('admin.rolepermission.index', [
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
       
        $permission = Permissionmod::orderBY('label_name', 'asc')->get();

        $role = Role::where(['active_status'=>1])->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Role', '');
        
        // dd($rolemenu);exit;

        return view('admin.rolepermission.form',compact('permission','role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolePermissionRequest $request)
    {
        
       $role_id = $request->role_id;
       $permission_id = $request->permission_id;
       
        if(!$permission_id) {
            Session::flash('error', 'Sorry, You must be selected any permission.');
            return back()->withInput($request->all());
        }

        $existed = roleHasPermission::where(['role_id'=>$role_id])->first();

        if($existed) {
            Session::flash('error', 'The role has already been taken.');
            return back()->withInput($request->all());
        }

        // dd($request->all());
        $permission = array();
        foreach($permission_id as $key=>$val) {
                $permission[] = $val;
        }

        foreach($permission as $key=>$val){

            $existed = roleHasPermission::where(['role_id'=>$role_id,'permission_id'=>$val])->first();
            if(!$existed) {
                $permissionadd = array(
                    'role_id'=>$role_id,
                    'permission_id'=>$val,
                );
                $insert = roleHasPermission::create($permissionadd);
            }
        }

       
        Session::flash('message', Lang::get('messages.save_success'));
        return redirect()->route('permissionrole.index');
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

        $existed = roleHasPermission::where(['role_id'=>$id])->first();

        if(!$existed) {
            Session::flash('error', 'Sorry, You can not access this information.');
            return back();
        }

      
        $permission = Permissionmod::orderBY('label_name', 'asc')->get();
       
      

        $role = Role::where(['active_status'=>1])->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Role', '');
        
        $item = roleHasPermission::where('role_id',$id)->get();

    
        foreach($permission as $key=>$val) {
            
          

            $permission[$key]['is_selected'] = 0;
            $menuexisted = roleHasPermission::where(['role_id'=>$id,'permission_id'=>$val->id])->first();
           
            if($menuexisted) {
                $permission[$key]['is_selected'] = 1;               
            }
        }

        // print_r($permission);
        
        return view('admin.rolepermission.edit')->with(['item'=>$item,'permission'=>$permission,'role'=>$role,'id'=>$id]);
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
        
        $role_id = $request->role_id;
        $permission_id = $request->permission_id;
       
        if(!$permission_id) {
            Session::flash('error', 'Sorry, You must be selected any permission.');
            return back()->withInput($request->all());
        }

    
       
        
        $permission = array();
        foreach($permission_id as $key=>$val) {
                $permission[] = $val;
        }

        roleHasPermission::where('role_id',$id)->delete();

        foreach($permission as $key=>$val){

            $existed = roleHasPermission::where(['role_id'=>$role_id,'permission_id'=>$val])->first();
            if(!$existed) {
                $permissionadd = array(
                    'role_id'=>$id,
                    'permission_id'=>$val,
                );
                $insert = roleHasPermission::create($permissionadd);
            }
        }


        Session::flash('message', Lang::get('messages.Updated successfully'));
        return redirect()->route('permissionrole.index');
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
        roleHasPermission::where('role_id',$id)->delete();

        Session::flash('message', Lang::get('messages.Deleted successfully'));
        return redirect()->route('permissionrole.index');
    }

 
    

}
