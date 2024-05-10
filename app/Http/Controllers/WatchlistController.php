<?php

namespace App\Http\Controllers;

use App\Models\DataBanksIntraday;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WatchlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $loginUserId = 1;
        $instruments = Watchlist::select('instrument_id',)
            ->where('customer_id','=',$loginUserId)
            ->orderBy('created_at','DESC')
//            ->toSql();
            ->get();

//        dd($instruments);

//        $loginUserId = $request->customer;
//        $instruments = $request->instrument;
        $today = date('2023-01-24');

        $collections = DataBanksIntraday::with('instrument:id,instrument_code as name')->select('id','instrument_id','trade_date','yday_close_price')
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN spot_last_traded_price ELSE pub_last_traded_price END AS last_traded_price")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((open_price - spot_last_traded_price) * 100 ) / open_price ELSE ((open_price -pub_last_traded_price) * 100) / open_price END AS pchange")
            ->selectRaw("CASE WHEN pub_last_traded_price = 0 THEN ((open_price - spot_last_traded_price)) ELSE (open_price - pub_last_traded_price)  END AS rchange")
            ->where('trade_date','=',$today)
            ->whereIn('instrument_id',$instruments)
            ->orderBy('lm_date_time','DESC')
            ->limit(5)
//            ->toSql();
            ->get();

        $response = array(
            'data'=>$collections,
            'success'=>"Success",
        );
        return response()->json($response);
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
//        $user_id = $request->customer;
//        $instrument_id = $request->instrument;

        $collections = Watchlist::create($request->all());

        $response = array(
            'data'=>$collections,
            'success'=>"Success",
        );
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Watchlist  $watchlist
     * @return \Illuminate\Http\Response
     */
    public function show(Watchlist $watchlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Watchlist  $watchlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Watchlist $watchlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Watchlist  $watchlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Watchlist $watchlist)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Watchlist  $watchlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
dd($request->all());
        $collections = Watchlist::find($request->id);
        $collections->delete();
        $response = array(
            'data'=>$collections,
            'success'=>"Success",
        );
        return response()->json($response);
    }
}
