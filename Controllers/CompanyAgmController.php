<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CompanyAgminfo;
use App\Http\Requests\CompanyAgmRequest;
use App\Http\Requests\CompanyBasicInfoRequest;
use App\Models\CompanyBasicInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;
class CompanyAgmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     $company_id ='';
    //     $page = 1;
    //     if ($request->isMethod('post')) {
    //         $company_id = $request->code;
    //       }

    //     $companys = DB::table('company_basic_information')->select('id','code')->get()->pluck('code', 'id')->prepend('Select Code', '0');

    //     $agm_info = DB::table('company_agm_information as info')
    //     ->leftjoin('company_basic_information','company_basic_information.id','=','info.company_id')
    //     ->select('company_basic_information.company_name','info.last_agm_held_on','info.right_issue','info.year_end','info.reserve_surplus','info.comprehensive_income','info.id as agmid')->get();
       
    //     if($company_id !='') {
    //         $company = $agm_info->where('info.company_id',$company_id);
    //      }
  
    //       $agm_info = $agm_info->sortByDesc('info.id');
  
    //     //   $agm_info =$agm_info->paginate(pageLimit());
  
    //     return view('admin.company.agm_info.agm_info_list',compact('agm_info','companys','company_id'));
    // }
    
    public function Index(Request $request)
    {
        // $company_id ='';
        // $page = 1;
        // if ($request->isMethod('post')) {
        //     $company_id = $request->code;
        //   }

        // $companys = DB::table('company_basic_information')->select('id','code')->get()->pluck('code', 'id')->prepend('Select Code', '0');

        $agm_info = DB::table('company_agm_information as info')
        ->leftjoin('company_basic_information','company_basic_information.id','=','info.company_id')
        ->select('company_basic_information.company_name','info.last_agm_held_on','info.right_issue','info.year_end','info.reserve_surplus','info.comprehensive_income','info.id as agmid','info.company_id')->get();
       
        // if($company_id !='') {
        //     $agm_info = $agm_info->where('company_basic_information.company_id',$company_id);
        //  }

        //   $agm_info = $agm_info->sortByDesc('company_basic_information.id');
        //   //$agm_info = $agm_info->paginate(pageLimit());
  
        return view('admin.company.agm_info.agm_info_list',compact('agm_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = ['' => 'Select company....'] + CompanyBasicInfo::select('id','company_name')->get()->pluck('company_name','id')->toArray();
        return view('admin.company.agm_info.create_agm_info',compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyAgmRequest $request)
    {   
        $register = new CompanyAgminfo();
        $register->company_id = $request->company_id;
        $register->last_agm_held_on = $request->last_agm_held_on;
        $register->right_issue = $request->right_issue;
        $register->year_end = $request->year_end;
        $register->reserve_surplus = $request->reserve_surplus;
        $register->comprehensive_income = $request->comprehensive_income;
        $register->created_by = auth()->user()->id;
        $register->save();
        // dd($register);
        return redirect('admin/company_agm')->with('status', 'New Agm Add Successfully');
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
        $info=CompanyAgminfo::find($id);
        $company = ['' => 'Select company....'] + CompanyBasicInfo::select('id','company_name')->get()->pluck('company_name','id')->toArray();
        return view('admin.company.agm_info.add_agm_info')->with(['item'=>$info,'company'=>$company]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyAgmRequest $request, $id)
    {
        $register = CompanyAgminfo::find($id);
        $register->company_id = $request->company_id;
        $register->last_agm_held_on = $request->last_agm_held_on;
        $register->right_issue = $request->right_issue;
        $register->year_end = $request->year_end;
        $register->reserve_surplus = $request->reserve_surplus;
        $register->comprehensive_income = $request->comprehensive_income;
        $register->updated_by = auth()->user()->id;
        $register->update();
        return redirect('admin/company_agm')->with('status', 'Agm Update Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyAgminfo $agminfo, $id)
    {        
        $info=CompanyAgminfo::find($id);
        $info->delete();
        Session::flash('message', Lang::get('messages.Deleted successfully'));
        return redirect('admin/company_agm');
    }
}
