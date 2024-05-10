<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Token;
use Illuminate\Support\Str;
use Auth;

class UserAuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }
    public function register() {
        return view('auth.register');
    }
    public function check(Request $request) {
        $request->validate([
            'email'=>'required|email|max:200',
            'password'=>'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
                
                $tokenid = (string)Str::uuid();
                $tokendata = Token::create([
                    'user_id'       => Auth()->user()->id,
                    'name'          => Auth()->user()->name,
                    'description'   => '',
                    'api_token'     => hash('sha256', $tokenid),
                    'limit'         => 1,
                ]);
                $user = User::where('email',$request->email)->first();
                $user['photo'] = null;
                $employee = Employee::select('id','photo')->where('user_id',Auth()->user()->id)->first();
               
                if($employee) {
                    
                    $user['photo'] = $employee->photo;

                }
               
                $user['token'] = $tokendata['api_token'];

                $request->session()->put('LoggedUser',$user );

            return redirect()->intended('/');
        }

        return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');

        // $user = User::where('email',$request->email)->first();
        // if($user) {

        //     if(Hash::check($request->password,$user->password)){
        //         Session::flash('message', 'Login has completed');
               
        //         $token = (string)Str::uuid();
        //         $tokendata = Token::create([
        //             'user_id'       => $user->id,
        //             'name'          => $user->name,
        //             'description'   => '',
        //             'api_token'     => hash('sha256', $token),
        //             'limit'         => 1,
        //         ]);

        //         $user['token'] = $tokendata['api_token'];

        //         $request->session()->put('LoggedUser',$user );

        //         return redirect('/');
        //     }
        //     else {
        //         Session::flash('message', 'Sorry, Your password is not correct');
        //         return back()->withInput();
        //     }

        // }
        // else {
        //     Session::flash('error', 'Login has not completed');
        //     return back()->withInput();
        // }
    }
    public function create(Request $request) {
        //validate request
        // return $request->input();
       

        $validator = Validator::make($request->all(), [
            'email'=>'required|email|unique:users|max:200',
            'username'=>'required|max:50|unique:users',
            'name'=>'required|max:200',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
        ]);

        if ($validator->fails()) {
            // return redirect()->route('register')->withErrors($validator);
            return redirect('register')->withErrors($validator)->withInput();
        }
        else {
            // echo 333;exit;
            $added_data = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);

            if($added_data) {
                Session::flash('message', 'Registration has  completed ');
                return redirect('register');
            }
            else {
                Session::flash('error', 'Registration has not completed');
                return redirect('register');
            }
            
        }
    }

    public function logout(Request $request) {

        if(session()->has('LoggedUser')){
            $userid = $request->session()->get('LoggedUser')->user_id;
            if($userid) {
                Token::where('user_id',$userid)->delete();
            }
            session()->pull('LoggedUser');
            Auth::logout();
            return redirect('login');
        }
        return back();
    }
    
}
