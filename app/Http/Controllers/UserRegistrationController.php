<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Office;
use App\Models\Store;
use App\Models\ModelHasRoles;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $collections = User::with('role','office:id,name','store:id,name')->orderBy('id','DESC')->get();
        return View('admin.user.index', [
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
        $role = Role::where('active_status',1)->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Role', '');
        $office = Office::where('active_status',1)->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Office', '');
        return view('admin.user.form',compact('isActivestatus','role','office'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
       
            $user = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'name' => $request->name,
                'role_id' => $request->role_id,
                'password' => Hash::make($request->password),
                'office_id' => $request->office_id,
                'store_id' => $request->store_id,
            ]);

            if($user) {
                if($request->role_id) {
                    $roleInfo = Role::where('id',$request->role_id)->first();
                    if($roleInfo) {
                        $user->assignRole($roleInfo->name);
                    }
                }
                Session::flash('message', 'User has  completed ');
            }
            else {
                Session::flash('error', 'User has not completed');
                
            }

            return redirect()->route('user.index');
            
        
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
    public function edit(User $user)
    {
        $isActivestatus = CommonController::enableDisable();
        $role = Role::where('active_status',1)->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Role', '');
        $office = Office::where('active_status',1)->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Office', '');

        return view('admin.user.form')->with(['item'=>$user,'isActivestatus'=>$isActivestatus,'role'=>$role,'office'=>$office]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validation_ck = array(
            'username' => [
                'required','max:150',
                Rule::unique('users')->ignore($id ?? 0),
            ],
            'email' => [
                'required','max:150',
                Rule::unique('users')->ignore($id ?? 0),
            ],
            'name'=>'required|max:200',
            'office_id'=>'required',
        );

        if($request->password) {
            $validation_ck['password'] = 'required|confirmed';
            $validation_ck['password_confirmation'] = 'required';
        }
        $validator = Validator::make($request->all(), $validation_ck);

        if ($validator->fails()) {
            // return redirect()->route('register')->withErrors($validator);
            return back()->withErrors($validator)->withInput();
        }
        else {
            // echo 333;exit;

            $data_upate = array(
                'email' => $request->email,
                'username' => $request->username,
                'name' => $request->name,
                'active_status' => $request->active_status,
                'role_id' => $request->role_id,
                'office_id' => $request->office_id,
                'store_id' => $request->store_id,
            );
    
            if($request->password) {
                $data_upate['password'] = Hash::make($request->password);
            }

            $user  = User::find($id);
           
            if($user) {
              
                if($request->role_id) {
                   
                    
                    $hasmodel = ModelHasRoles::where('model_id',$user->id)->first();
                   
                    if(!$hasmodel) {
                        $roleInfo = Role::where('id',$request->role_id)->first();
                        if($roleInfo) {
                            if(!$user->hasRole($roleInfo->name)){
                                $user->assignRole($roleInfo->name);
                            }
                            
                        }
                    }
                    else {
                        $roleInfo = Role::where('id',$request->role_id)->first();
                        $user->syncRoles($roleInfo->name);
                    }
                    
                }

                User::where('id', $id)->update($data_upate);
               
                Session::flash('message', 'User has  completed ');
                return redirect()->route('user.index');
            
               
            }

            else {
                Session::flash('error', 'User has not completed');
                return back()->withErrors($validator)->withInput();
            }
         
           
            
        }

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

  
}
