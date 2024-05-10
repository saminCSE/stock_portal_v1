<?php

namespace App\Http\Controllers;

use App\Models\DataBanksEod;
use App\Models\Mkistat;
use App\Models\DataBanksIntraday;
use App\Models\IndexValue;
use App\Models\Instrument;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DseStatisticeController extends Controller
{

    public function __construct()
    {
       //
    }
    
    public function getMkistat(Request $request) {

        $fromDate = date('Y-m-d');
        $toDate   = date('Y-m-d');
        $page = 1;
        if ($request->isMethod('post')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
        }
        

        $collections = Mkistat::whereRaw(
            "(date(lm_date_time) >= ? AND date(lm_date_time) <= ?)", 
            [
               $fromDate, 
               $toDate
            ]
          )
          ->paginate(pageLimit());

        // dd($collections);

        return view('admin.dse.mkistatlist',compact('collections','fromDate','toDate'));
    }
    
    public function intraData(Request $request) {

        $fromDate = date('Y-m-d');
        $toDate   = date('Y-m-d');
        $instrument_id = '0';
        $page = 1;
        if ($request->isMethod('post')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
            $instrument_id = $request->instrument_id;
        }
        
        $instruments = Instrument::select('id','instrument_code','name')->where('active','=',1)->orderBy('instrument_code','ASC')->get()->pluck('instrument_code', 'id')->prepend('Select Instrument', '0');

        $collections = DataBanksIntraday::with('instrument')->whereRaw(
            "(date(trade_date) >= ? AND date(trade_date) <= ?)", 
            [
               $fromDate, 
               $toDate
            ]
            );

          if($instrument_id != 0) {
            $collections = $collections->where('instrument_id',$instrument_id);
         }
 
      
          $collections = $collections->orderBy('id','ASC')->paginate(pageLimit());
        
        //   $offset = $collections->perPage;
        // dd($collections);

        return view('admin.dse.dailymarket',compact('collections','fromDate','toDate','instrument_id','instruments'));
    }

    public function intraDataEod(Request $request) {

        $fromDate = date('Y-m-d');
        $toDate   = date('Y-m-d');
        $instrument_id = '0';
        $page = 1;
        if ($request->isMethod('post')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
            $instrument_id = $request->instrument_id;
        }

        $instruments = Instrument::select('id','instrument_code','name')->where('active','=',1)->orderBy('instrument_code','ASC')->get()->pluck('instrument_code', 'id')->prepend('Select Instrument', '0');
        
        // dd($instruments);
        $collections = DataBanksEod::with('instrument')->whereRaw(
            "(date(date) >= ? AND date(date) <= ?)", 
            [
               $fromDate, 
               $toDate
            ]
            );
       

        if($instrument_id != 0) {
           $collections = $collections->where('instrument_id',$instrument_id);
        }

       $collections = $collections->paginate(pageLimit());

        //dd($collections);
        
        //   $offset = $collections->perPage;
        // dd($collections);

        return view('admin.dse.intra_day_eod',compact('collections','fromDate','toDate','instruments','instrument_id'));
    }
    public function indexData(Request $request) {

        $fromDate = date('Y-m-d');
        $toDate   = date('Y-m-d');
        $instrument_id = '0';
        $page = 1;
        if ($request->isMethod('post')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
            $instrument_id = $request->instrument_id;
        }

        $instruments = Instrument::select('id','instrument_code','name')->whereIn('id',[10001,10002,10003])->orderBy('instrument_code','ASC')->get()->pluck('instrument_code', 'id')->prepend('Select Index', '0');
        
        // dd($instruments);
        $collections = IndexValue::with('instrument')->whereRaw(
            "(date(index_date) >= ? AND date(index_date) <= ?)", 
            [
               $fromDate, 
               $toDate
            ]
            );
       

            
        if($instrument_id != 0) {
           $collections = $collections->where('instrument_id',$instrument_id);
        }

        $collections = $collections->orderBy('id','DESC');

       $collections = $collections->paginate(pageLimit());

       

        return view('admin.dse.index_value',compact('collections','fromDate','toDate','instruments','instrument_id'));
    }
    public function MarketData(Request $request)
    {
        $market =DB::table('markets')->get();
        $fromDate = date('Y-m-d');
        $toDate   = date('Y-m-d');
        $page = 1;
        if ($request->isMethod('post')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
        }
      $market= DB::table('markets')->whereRaw("(date(trade_date) >= ? AND date(trade_date) <= ?)", 
            [
               $fromDate, 
               $toDate
            ]
            );
            
        $market = $market->orderBy('id','DESC');

        $market = $market->paginate(pageLimit());
        
        return view('admin.dse.market_list',compact('fromDate','toDate','market'));
    }
}
