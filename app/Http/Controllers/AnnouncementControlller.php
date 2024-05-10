<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\DB;
 use App\Models\Instrument;

class AnnouncementControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    }
    public function Index_Announcement(Request $request)
    {
        $fromDate = date('Y-m-d');
        $toDate   = date('Y-m-d');
        $instrument_id = '0';
        $page = 1;
        if ($request->isMethod('post')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
            $instrument_id = $request->instrument_id;
        }
        
        $instruments = Instrument::select('id','instrument_code','name')->where('active','=',1)->orderBy('name','ASC')->get()->pluck('name', 'id')->prepend('Select Instrument', '0');
       
        $announce = DB::table('news')
        ->leftJoin('instruments', 'news.instrument_id', '=', 'instruments.id')
        ->select('news.id', 'news.market_id', 'news.prefix as prefix', 'news.title', 'news.details', 'news.post_date', 'news.expire_date', 'news.is_active', 'news.updated', 'instruments.name as instruments_name')
        ->whereRaw(
            "(date(post_date) >= ? AND date(post_date) <= ?)", 
            [
               $fromDate, 
               $toDate
            ]
            );
        
         
        if($instrument_id != 0) {
            $announce = $announce->where('instrument_id',$instrument_id);
         }
           
         $announce = $announce->orderBy('id','DESC');

         $announce = $announce->paginate(pageLimit());

        return view('admin.announcement.list',compact('announce','fromDate','toDate','instrument_id','instruments'));
    }


    
    public function announceDetails($id){
         $announce = DB::table('news')
          ->leftJoin('instruments','news.instrument_id', '=', 'instruments.id')
          ->select('news.id','news.market_id as market_id', 'news.prefix as prefix', 'news.title as title', 'news.details as details', 'news.post_date as post_date', 'news.expire_date as expire_date', 'news.is_active as is_active', 'news.updated as updated', 'instruments.name as instruments_name')
          ->where('news.id','=', $id)
          ->first();
        if($announce){
            return response()->json(
                [
                    'status'=>200,
                    'announce'=>$announce,
                ]);
        }
        else{
            return response()->json(
                [
                    'status'=>404,
                    'message'=>'announce not found',
                ]);
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
