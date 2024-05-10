<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instrument;
use Illuminate\Support\Facades\DB;
use App\Models\Exchange;
use App\Models\Sector;
use App\Models\Company;
use Validator;

class InstrumentController extends Controller
{
    public function Index(Request $request)
    {
        // dd($request->index);
        $instrumentQuery = DB::table('instruments')
            ->leftjoin('sector', 'sector.id', '=', 'instruments.sector_list_id')
            ->select('instruments.id', 'instruments.exchange_id', 'instruments.instrument_code', 'instruments.isin', 'instruments.name', 'instruments.is_spot', 'instruments.active', 'instruments.batch_id', 'instruments.market_id', 'sector.name as sector_name')
            ->orderBy('id', 'desc');

        if (isset($request->instrument_id) && $request->instrument_id != '-1') {
            $instrumentQuery->where('instruments.id', $request->instrument_id);
        }
        if (isset($request->sector) && $request->sector != '-1') {
            $instrumentQuery->where('sector.id', $request->sector);
        }
        if (isset($request->index) && in_array('DSEX', $request->index)) {
            $instrumentQuery->where('instruments.isdsex', 1);
        }
        if (isset($request->index) && in_array('DSES', $request->index)) {
            $instrumentQuery->where('instruments.isdses', 1);
        }
        if (isset($request->index) && in_array('DS30', $request->index)) {
            $instrumentQuery->where('instruments.isds30', 1);
        }

        $instrument = $instrumentQuery->paginate(10);


        $instrument_list = DB::table('instruments')
            ->select('instruments.id', 'instruments.instrument_code')
            ->orderBy('instruments.instrument_code', 'asc')->get();

        $sector_list = DB::table('sector')
            ->select('sector.id', 'sector.name')
            ->orderBy('sector.name', 'asc')->get();
        // dd($instrument_list);
        return view('admin.instrument.instrument_list', compact('instrument', 'instrument_list', 'sector_list','request'));
    }
    public function CreateInstrument()
    {
        $isActivestatus = CommonController::enableDisable();
        $isstatus = CommonController::yesno();
        $exchange = Exchange::select('id', 'name')->get()->pluck('name', 'id')->prepend('Select', '');
        $sector = ['' => 'Select Sector....'] + Sector::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $instrumentName = ['' => 'Select Instrument....'] + Company::select('name', 'name')->orderBy('id', 'DESC')->get()->pluck('name', 'name')->toArray();
        $instrumentCode = ['' => 'Select Code....'] + Company::select('code', 'code')->orderBy('id', 'DESC')->get()->pluck('code', 'code')->toArray();
        return view('admin.instrument.create_instrument', compact('exchange', 'sector', 'isActivestatus', 'isstatus', 'instrumentName', 'instrumentCode'));
    }
    public function Instrumentregister(Request $request)
    {

        $request->validate([
            'exchange_id' => 'required',
            'sector_list_id' => 'required',
            'instrument_code' => 'required|unique:instruments',
            'category' => 'required',
            'isin' => 'required',
            'name' => 'required|unique:instruments',
            'is_spot' => 'required',
            'active' => 'required',
            'index' => 'required|array',
            'index.*' => 'in:DSES,DSEX,DS30',
        ]);
        // dd($request->all());
        $register = new Instrument();
        $register->exchange_id = $request->exchange_id;
        $register->sector_list_id = $request->sector_list_id;
        $register->instrument_code = $request->instrument_code;
        $register->isin = $request->isin;
        $register->name = $request->name;
        $register->is_spot = $request->is_spot;
        $register->active = $request->active;
        $register->isdsex = in_array('DSEX', $request->index) ? 1 : 0;
        $register->isdses = in_array('DSES', $request->index) ? 1 : 0;
        $register->isds30 = in_array('DS30', $request->index) ? 1 : 0;
        $register->save();


        return redirect()->back()->with('status', 'New instrument Create Successfully');
    }
    public function show($id)
    {
        $instrument = Instrument::find($id);
        $isActivestatus = CommonController::enableDisable();
        $isstatus = CommonController::yesno();
        $exchange = Exchange::select('id', 'name')->get()->pluck('name', 'id')->prepend('Select', '');
        $sector = Sector::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        return view('admin.instrument.edit_instrument')->with(['item' => $instrument, 'isActivestatus' => $isActivestatus, 'isstatus' => $isstatus, 'exchange' => $exchange, 'sector' => $sector]);
    }
    public function update_Instrument(Instrument $instruments, Request $request, $id)
    {
        $instruments = Instrument::find($id);
        $instruments->exchange_id = $request->exchange_id;
        $instruments->sector_list_id = $request->sector_list_id;
        $instruments->instrument_code = $request->instrument_code;
        $instruments->isin = $request->isin;
        $instruments->name = $request->name;
        $instruments->is_spot = $request->is_spot;
        $instruments->active = $request->active;
        $instruments->isdsex = in_array('DSEX', $request->index) ? 1 : 0;
        $instruments->isdses = in_array('DSES', $request->index) ? 1 : 0;
        $instruments->isds30 = in_array('DS30', $request->index) ? 1 : 0;
        $instruments->save();
        return redirect('/admin/instrument/list')->with('status', 'Instruments Updated Successfully');
    }
    public function deleteInstrument($id)
    {
        $instruments = Instrument::find($id);
        $instruments->delete();
        return redirect()->back()->with('status', 'Instruments Delete Successfully.');
    }
}
