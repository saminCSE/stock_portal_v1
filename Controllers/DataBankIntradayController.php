<?php

namespace App\Http\Controllers;
use App\Models\Market;
use App\Models\Instrument;
use App\Models\DataBanksIntraday;
use Illuminate\Http\Request;
use App\Http\Requests\DataBankIntradayRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class DataBankIntradayController extends Controller
{

    public function CreateDailyData()
    {
        
        $instrument= ['' =>'Select Instrument....'] + Instrument::select('id','name')->orderBy('id','DESC')->get()->pluck('name','id')->toArray();
        $market = ['' => 'Select Market....']+ Market::select('id','trade_date')->get()->pluck('trade_date','id')->toArray();
        return view('admin.dse.create_daily_data', compact('market','instrument'));
    }

    public function DailyDataStore(DataBankIntradayRequest $request)
    {
    $register = new DataBanksIntraday();
    $register->market_id = $request->market_id;
    $register->instrument_id = $request->instrument_id;
    $register->quote_bases = $request->quote_bases;
    $register->open_price = $request->open_price;
    $register->pub_last_traded_price = $request->pub_last_traded_price;
    $register->spot_last_traded_price = $request->spot_last_traded_price;
    $register->high_price = $request->high_price;
    $register->low_price = $request->low_price;
    $register->close_price = $request->close_price;
    $register->yday_close_price = $request->yday_close_price;
    $register->total_trades = $request->total_trades;
    $register->total_volume = $request->total_volume;
    $register->new_volume = $request->new_volume;
    $register->total_value = $request->total_value;
    $register->public_total_trades = $request->public_total_trades;
    $register->public_total_volume = $request->public_total_volume;
    $register->public_total_value = $request->public_total_value;
    $register->spot_total_trades = $request->spot_total_trades;
    $register->spot_total_volume = $request->spot_total_volume;
    $register->spot_total_value = $request->spot_total_value;
    $register->lm_date_time = $request->lm_date_time;
    $register->trade_time = $request->trade_time;
    $register->trade_date = $request->trade_date;
    $register->batch = $request->batch;
    $register->save();
    return redirect('admin/dse/intraData')->with('status', 'Daily Data Add Successfully');
    }

    public function DailyDataShow($id)
    {
        $item = DataBanksIntraday::find($id);
        $instrument= ['' =>'Select Instrument....'] + Instrument::select('id','name')->orderBy('id','DESC')->get()->pluck('name','id')->toArray();
        $market = ['' => 'Select Market....']+ Market::select('id','trade_date')->get()->pluck('trade_date','id')->toArray();
        return view('admin.dse.create_daily_data', compact('market','instrument','item'));
    }
    public function DailyDataUpdate(DataBankIntradayRequest $request,$id)
    {
    $register =DataBanksIntraday::find($id);
    $register->quote_bases = $request->quote_bases;
    $register->open_price = $request->open_price;
    $register->pub_last_traded_price = $request->pub_last_traded_price;
    $register->spot_last_traded_price = $request->spot_last_traded_price;
    $register->high_price = $request->high_price;
    $register->low_price = $request->low_price;
    $register->close_price = $request->close_price;
    $register->yday_close_price = $request->yday_close_price;
    $register->total_trades = $request->total_trades;
    $register->total_volume = $request->total_volume;
    $register->new_volume = $request->new_volume;
    $register->total_value = $request->total_value;
    $register->public_total_trades = $request->public_total_trades;
    $register->public_total_volume = $request->public_total_volume;
    $register->public_total_value = $request->public_total_value;
    $register->spot_total_trades = $request->spot_total_trades;
    $register->spot_total_volume = $request->spot_total_volume;
    $register->spot_total_value = $request->spot_total_value;
    $register->lm_date_time = $request->lm_date_time;
    $register->trade_time = $request->trade_time;
    $register->trade_date = $request->trade_date;
    $register->batch = $request->batch;
    $register->update();
    return redirect('admin/dse/intraData')->with('status','Daily Data Updated Successfully');
    }

    public function destroy($id)
    {        
        $info=DataBanksIntraday::find($id);
        $info->delete();
        Session::flash('message', Lang::get('messages.Deleted successfully'));
        return redirect('admin/dse/intraData');
    }

}
