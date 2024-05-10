<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use App\Models\Market;
use App\Models\Instrument;
use App\Models\DataBanksEod;
use App\Models\Sector;
use App\Http\Requests\DataBankEODRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class DataBankEODController extends Controller
{
    public function CreateDataEod()
    {

        $instrument= ['' =>'Select Instrument....'] + Instrument::select('id','name')->orderBy('id','DESC')->get()->pluck('name','id')->toArray();
        $market = ['' => 'Select Market....']+ Market::select('id','trade_date')->get()->pluck('trade_date','id')->toArray();
        $sector = ['' => 'Select Sector....'] + Sector::select('id','name')->get()->pluck('name','id')->toArray();
        return view('admin.dse.create_intra_day_eod', compact('market','instrument','sector'));
    }

    public function DataEodStore(DataBankEODRequest $request)
    {
    $register = new DataBanksEod();
    $register->market_id = $request->market_id;
    $register->instrument_id = $request->instrument_id;
    $register->sector_id = $request->sector_id;
    $register->open = $request->open;
    $register->high = $request->high;
    $register->low = $request->low;
    $register->close = $request->close;
    $register->ycp = $request->ycp;
    $register->volume = $request->volume;
    $register->trade = $request->trade;
    $register->tradevalues = $request->tradevalues;
    $register->date = $request->date;
    $register->updated = $request->updated;
    $register->market_instrument = $request->market_instrument;
    $register->batch = $request->batch;
    $register->save();
    return redirect('admin/dse/intradataeod')->with('status', 'Data EOD Add Successfully');
    }

    public function DataEodShow($id)
    {
        $item = DataBanksEod::find($id);
        $instrument= ['' =>'Select Instrument....'] + Instrument::select('id','name')->orderBy('id','DESC')->get()->pluck('name','id')->toArray();
        $market = ['' => 'Select Market....']+ Market::select('id','trade_date')->get()->pluck('trade_date','id')->toArray();
        $sector = ['' => 'Select Sector....'] + Sector::select('id','name')->get()->pluck('name','id')->toArray();
        return view('admin.dse.create_intra_day_eod', compact('market','instrument','sector','item'));
    }
    public function DataEodUpdate(DataBankEODRequest $request,$id)
    {
        $register =DataBanksEod::find($id);
        $register->open = $request->open;
        $register->high = $request->high;
        $register->low = $request->low;
        $register->close = $request->close;
        $register->ycp = $request->ycp;
        $register->volume = $request->volume;
        $register->trade = $request->trade;
        $register->tradevalues = $request->tradevalues;
        $register->date = $request->date;
        $register->updated = $request->updated;
        $register->market_instrument = $request->market_instrument;
        $register->batch = $request->batch;
        $register->update();
        return redirect('admin/dse/intradataeod')->with('status','Data EOD Updated Successfully');
    }

    public function destroy($id)
    {
        $info=DataBanksEod::find($id);
        $info->delete();
        Session::flash('message', Lang::get('messages.Deleted successfully'));
        return redirect('admin/dse/intradataeod');
    }

}
