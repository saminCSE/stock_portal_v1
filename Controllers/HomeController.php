<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\roleHasPermission;
use App\Models\MarketSchedule;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public $getloginuser;
    

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() {
        // DB::enableQueryLog();
        // auth()->user()->assignRole('admin', 'admin');
        $store_id = '';//Auth()->user()->store_id;
      
        return view('admin.dashboard.index');
    }
    public function profile(Request $request) {
        // auth()->user()->assignRole('admin', 'office');
        return view('admin.profile.index');
    }
    public function item(Request $request) {

        return view('admin.item.index');
    }
    public function supplier(Request $request) {

        return view('admin.supplier.index');
    }
    public function user(Request $request) {

        return view('admin.user.index');
    }
    public function employee(Request $request) {

        return view('admin.supplier.index');
    }
    public function training(Request $request) {

        return view('admin.user.index');
    }
    public function Market() {
        return view('admin.market.market');
    }
    public function MarketSchedule(Request $request)
    {
    $register=new MarketSchedule();

    $register->open_date = $request->open_date;
    $register->open_time =$request->open_time;
    $register->close_date =$request->close_date;
    $register->close_time =$request->close_time;
    $register->comments =$request->comments;
    $register->save();

   return redirect()->back()->with('status','Schedule Insert Successfully');
    }
}
