<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Instrument;
use  Illuminate\Support\Facades\DB;
use App\Models\CompanyBasicInfo;
use App\Http\Requests\CompanyBasicInfoRequest;
use App\Http\Controllers\CommonController;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $company_id = '';
        $page = 1;
        if ($request->isMethod('post')) {
            $company_id = $request->code;
        }
        $companys = DB::table('company')->select('id', 'code')->orderBy('name', 'ASC')->get()->pluck('code', 'id')->prepend('Select Code', '0');

        $company = DB::table('company')
            ->leftJoin('instruments', 'company.code', '=', 'instruments.instrument_code')
            ->select('company.id as comapny_id', 'company.name', 'company.code as code', 'company.xcode', 'company.symbol', 'instruments.id as Instruments_id', 'instruments.instrument_code as Instruments_code');

        if ($company_id != '') {
            $company = $company->where('company.id', $company_id);
        }


        $company = $company->orderBy('company.id', 'DESC');
        $company = $company->paginate(pageLimit());

        return view('admin.company.list', compact('company', 'company_id', 'companys'));
    }

    public function CreateCompanyBasicInfo()
    {
        $status = CommonController::yesno();
        return view('admin.company.company_basic_info.add_basic_info', compact('status'));
    }

    public function AddCompanyBasicInfo(CompanyBasicInfoRequest $request)
    {

        $register = new CompanyBasicInfo();
        $register->company_name = $request->company_name;
        $register->code = $request->code;
        $register->xcode = $request->xcode;
        $register->company_description = $request->company_description;
        $register->incorporation_date = $request->incorporation_date ? $request->incorporation_date : NULL;
        $register->scrip_code_dse = $request->scrip_code_dse;
        $register->scrip_code_cse = $request->scrip_code_cse;
        $register->listing_year_dse = $request->listing_year_dse;
        $register->listing_year_cse = $request->listing_year_cse;
        $register->market_category = $request->market_category;
        $register->electronic_share = $request->electronic_share;
        $register->corporate_office_address = $request->corporate_office_address;
        $register->head_office_address = $request->head_office_address;
        $register->factory_office_address = $request->factory_office_address;
        $register->fax = $request->fax;
        $register->phone = $request->phone;
        $register->save();
        return redirect('admin/company_basic_info/list')->with('status', 'contact_info Add Successfully');
    }
    public function CompanyBasicInfoShow($id)
    {
        $info = CompanyBasicInfo::find($id);
        $status = CommonController::yesno();
        return view('admin.company.company_basic_info.add_basic_info')->with(['item' => $info, 'status' => $status]);
    }
    public function UpdateCompanyBasicInfoShow(CompanyBasicInfoRequest $request, $id)
    {
        $register = CompanyBasicInfo::find($id);
        $register->company_name = $request->company_name;
        $register->code = $request->code;
        $register->xcode = $request->xcode;
        $register->company_description = $request->company_description;
        $register->incorporation_date = $request->incorporation_date;
        $register->scrip_code_dse = $request->scrip_code_dse;
        $register->scrip_code_cse = $request->scrip_code_cse;
        $register->listing_year_dse = $request->listing_year_dse;
        $register->listing_year_cse = $request->listing_year_cse;
        $register->market_category = $request->market_category;
        $register->electronic_share = $request->electronic_share;
        $register->corporate_office_address = $request->corporate_office_address;
        $register->head_office_address = $request->head_office_address;
        $register->factory_office_address = $request->factory_office_address;
        $register->fax = $request->fax;
        $register->phone = $request->phone;
        $register->update();
        return redirect('admin/company_basic_info/list')->with('status', 'Company Update Successfully');
    }

    public function CompanyBasicInfo(Request $request)
    {
        $info = DB::table('company_basic_information as info')
            // ->select('info.id', 'info.company_name', 'info.code', 'info.xcode', 'info.company_description', 'info.incorporation_date', 'info.scrip_code_dse', 'info.scrip_code_cse', 'info.listing_year_dse', 'info.listing_year_cse', 'info.market_category', 'info.electronic_share', 'info.corporate_office_address', 'info.head_office_address', 'info.factory_office_address', 'info.fax', 'info.phone');
            ->select('info.*');
        $info = $info->orderBy('info.id', 'ASC');
        $info = $info->paginate(pageLimit());
        return view('admin.company.company_basic_info.basic_info_list', compact('info'));
    }

    public function CompanyBasicInfoDetails($id)
    {
        $info = DB::table('company_basic_information as info')
            // ->select('info.id', 'info.company_name', 'info.code', 'info.xcode', 'info.company_description', 'info.incorporation_date', 'info.scrip_code_dse', 'info.scrip_code_cse', 'info.listing_year_dse', 'info.listing_year_cse', 'info.market_category', 'info.electronic_share', 'info.corporate_office_address', 'info.head_office_address', 'info.factory_office_address', 'info.fax', 'info.phone')
            ->select('info.*')
            ->where('info.id', '=', $id)
            ->first();
        if ($info) {
            return response()->json(
                [
                    'status' => 200,
                    'info' => $info,
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'info not found',
                ]
            );
        }
    }
}
