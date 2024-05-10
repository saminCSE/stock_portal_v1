<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlockTransactionRequest;
use App\Models\BlockTransaction;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class BlockTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blockTransactions = DB::table('instruments')
            ->join('block_transactions','instruments.id','block_transactions.instrument_id')
            ->orderBy('block_transactions.id', 'desc')
            ->get();
        return view('admin.block_transaction.index',compact('blockTransactions'));
    }

    /**
     * Show the form for creating a new resource.
     *F
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $instruments = Instrument::select('id','instrument_code','name')->where('active','=',1)
            ->orderBy('instrument_code','ASC')->get()->pluck('instrument_code', 'id')->prepend('Select Instrument', '0');
        return view('admin.block_transaction.form',compact('instruments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockTransactionRequest $request)
    {
        $instrumentalCheck = BlockTransaction::select('*')
            ->where('instrument_id', $request->input('instrument_id'))
            ->whereDate('transaction_date', '=', date('Y-m-d'))
            ->first();

        if($instrumentalCheck == null){
            BlockTransaction::create($request->all());
            Session::flash('message', 'New Block Transaction Create Successfully');
            return redirect()->route('blocktransaction.create');
        }
        else{
            Session::flash('error', 'This Symbol data is already input on this date please do an update!');
            return redirect()->route('blocktransaction.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlockTransaction  $blockTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(BlockTransaction $blockTransaction)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlockTransaction  $blocktransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(BlockTransaction $blocktransaction,Request $request)
    {
        $instruments = Instrument::select('id','instrument_code','name')->where('active','=',1)->orderBy('instrument_code','ASC')->get()->pluck('instrument_code', 'id')->prepend('Select Instrument', '0');
        return view('admin.block_transaction.form')->with(['item'=>$blocktransaction,'instruments'=>$instruments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlockTransaction  $blockTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(BlockTransactionRequest $request, BlockTransaction $blocktransaction)
    {
        $blocktransaction->update($request->all());
        return redirect()->route('blocktransaction.index')->with('status', 'BlockTransaction Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlockTransaction  $blockTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlockTransaction $blocktransaction)
    {
        $blocktransaction->delete();
        return redirect()->back()->with('status', 'Block Transaction Delete Successfully');
    }
}
