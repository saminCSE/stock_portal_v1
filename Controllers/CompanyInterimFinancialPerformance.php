<?php

namespace App\Http\Controllers;

use App\Models\CompanyInterimFinancial;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CompanyInterimFinancialRequest;

class CompanyInterimFinancialPerformance extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interim = DB::table('company_interim_financial_performance as interim')
            ->leftJoin('company','company.id', '=', 'interim.company_id')
            ->select('company.name as company_name', 'interim.*','interim.id as interimid');
        $interim = $interim->paginate(pageLimit());

        return view('admin.company.company_interim_financial.interim_index', compact('interim'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = ['' => 'Select company....'] + Company::select('id','name')->get()->pluck('name','id')->toArray();
        return view('admin.company.company_interim_financial.add_Interim_financial',compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyInterimFinancialRequest $request)
    {
        $register = new CompanyInterimFinancial();
        $register->company_id = $request->company_id;
        $register->turnover = $request->turnover;
        $register->pfco = $request->pfco;
        $register->pftp	= $request->pftp;
        $register->tcip = $request->tcip;
        $register->basic_eps = $request->basic_eps;
        $register->diluted_eps = $request->diluted_eps;
        $register->basic_epsco = $request->basic_epsco;
        $register->diluted_epsco = $request->diluted_epsco;
        $register->mppspe = $request->mppspe;
        $register->q1 = $request->q1;
        $register->q2 = $request->q2;
        $register->half_yearly = $request->half_yearly;
        $register->q3 = $request->q3;
        $register->nine_months = $request->nine_months;
        $register->annual = $request->annual;
        $register->save();
        return redirect()->back()->with('status','New Interim Add Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $interim = CompanyInterimFinancial::find($id);
        $company = ['' => 'Select company....'] + Company::select('id','name')->get()->pluck('name','id')->toArray();
        return view('admin.company.company_interim_financial.add_Interim_financial')->with(['item'=>$interim,'company'=>$company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyInterimFinancialRequest $request, $id)
    {
        $register = CompanyInterimFinancial::find($id);
        $register->company_id = $request->company_id;
        $register->turnover = $request->turnover;
        $register->pfco = $request->pfco;
        $register->pftp	= $request->pftp;
        $register->tcip = $request->tcip;
        $register->basic_eps = $request->basic_eps;
        $register->diluted_eps = $request->diluted_eps;
        $register->basic_epsco = $request->basic_epsco;
        $register->diluted_epsco = $request->diluted_epsco;
        $register->mppspe = $request->mppspe;
        $register->q1 = $request->q1;
        $register->q2 = $request->q2;
        $register->half_yearly = $request->half_yearly;
        $register->q3 = $request->q3;
        $register->nine_months = $request->nine_months;
        $register->annual = $request->annual;
        $register->update();
        return redirect('admin/company_interim')->with('status','Interim Updated Successfully');
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

    public function CompanyInterimDetails($id)
    {
        $interim = DB::table('company_interim_financial_performance as interim')
        ->leftJoin('company','company.id', '=', 'interim.company_id')
         ->select('company.name as company_name', 'interim.*')
        ->where('interim.id','=', $id)
        ->first();
       if($interim){
           return response()->json(
               [
                   'status'=>200,
                   'interim'=>$interim,
               ]);
       }
       else{
           return response()->json(
               [
                   'status'=>404,
                   'message'=>'info not found',
               ]);
       }
    }
    
}
