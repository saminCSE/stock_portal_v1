<?php

namespace App\Http\Controllers;

use App\Models\BoType;
use App\Models\Broker;
use App\Models\Charge;
use App\Models\Margin;
use App\Models\BoCategory;
use App\Models\Occupation;
use App\Models\Relationship;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BeneficiaryOwners;
use App\Models\BoAccountNominees;
use Illuminate\Support\Facades\DB;
use App\Mail\BeneficiaryOwnersMail;
use Illuminate\Support\Facades\Mail;
use App\Models\BeneficiaryAuthorized;
use App\Models\BeneficiaryOwnersBank;
use App\Models\BeneficiaryJointHolders;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\CommonController;
use App\Http\Requests\BeneficiaryOwnersRequest;

class BeneficiaryOwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beneficiaryOwners = DB::table('beneficiary_owners')
            ->join('brokers', 'brokers.id', 'beneficiary_owners.broker_id')
            ->join('bo_categories', 'bo_categories.id', 'beneficiary_owners.bo_category_id')
            ->join('bo_types', 'bo_types.id', 'beneficiary_owners.bo_type_id')
            // ->where('beneficiary_owners.is_active', 1)
            ->orderBy('beneficiary_owners.id', 'desc')
            ->select(
                'beneficiary_owners.*',
                'brokers.id as broker_id',
                'brokers.name AS broker_name',
                'bo_categories.id as bo_categories_id',
                'bo_categories.title AS bo_categories_name',
                'bo_types.id as bo_types_id',
                'bo_types.title AS bo_types_name',
            )
            ->get();

        return view('admin.beneficiary_owner.index', compact('beneficiaryOwners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countryes = DB::table('country')
            ->select('id', 'nicename')
            ->get()
            ->pluck('nicename', 'id')->prepend('Select Country', '');

        $IsYesNo = CommonController::isYesNo();
        $IsActive = CommonController::isActive();
        $StatementCycleCode = CommonController::statementCycleCode();
        $gender = CommonController::gender();
        // $occupation = CommonController::occupation();
        $occupation = Occupation::where(['is_active' => 1])->orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Occupation', '');
        $nationality = CommonController::nationality();
        $residency = CommonController::residency();
        $relation = CommonController::relation();
        $ifNomineeIsMinor = CommonController::ifNomineeIsMinor();
        $isExchangeListedCompany = CommonController::isExchangeListedCompany();
        $authorizationType = CommonController::authorizationType();
        $brokers = Broker::where(['is_active' => 1])->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Broker', '');
        $charges = Charge::where(['title' => 'Commission'])->orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Charge', '');
        $marginValue = Margin::where(['is_active' => 1])->orderBY('id', 'asc')->get()->pluck('title', 'id')->prepend('Select Margin Value', '');

        $relationships = Relationship::where(['is_active' => 1])->orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Relation', '');

        $IsYesNo = CommonController::IsYesNo();
        $IsActive = CommonController::IsActive();
        $StatementCycleCode = CommonController::StatementCycleCode();
        $gender = CommonController::Gender();
        // $occupation = CommonController::Occupation();
        $nationality = CommonController::Nationality();
        $residency = CommonController::Residency();
        $relation = CommonController::Relation();
        $ifNomineeIsMinor = CommonController::IfNomineeIsMinor();
        $isExchangeListedCompany = CommonController::IsExchangeListedCompany();
        $authorizationType = CommonController::AuthorizationType();
        $brokers = Broker::where(['is_active' => 1])->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Broker', '');
        $relationships = Relationship::where(['is_active' => 1])->orderBY('id', 'asc')->get()->pluck('title', 'id')->prepend('Select Relation', '');

        $boCategoryId = BoCategory::where(['is_active' => 1])->orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Bo Category', '');
        $boTypeId = BoType::where(['is_active' => 1])->orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Bo Type', '');

        return view('admin.beneficiary_owner.form', compact(
            'boCategoryId',
            'boTypeId',
            'residency',
            'nationality',
            'gender',
            'occupation',
            'countryes',
            'relation',

            'isExchangeListedCompany',
            'isExchangeListedCompany',
            'authorizationType',
            'ifNomineeIsMinor',
            'brokers',
            'IsYesNo',
            'IsActive',
            'StatementCycleCode',
            'relationships',
            'charges',
            'marginValue'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BeneficiaryOwnersRequest $request)
    {

        // BeneficiaryOwnersRequest
        // dd($request->all());

        // return $request->all();
        $beneficiary_owners_id  = BeneficiaryOwners::storeBeneficiaryOwners($request);
        BeneficiaryOwnersBank::storeBeneficiaryOwnersBank($request, $beneficiary_owners_id);
        BoAccountNominees::storeBoAccountNominees($request, $beneficiary_owners_id);
        if($request->is_joint_account == 1){
         BeneficiaryJointHolders::storeBeneficiaryJointHolders($request, $beneficiary_owners_id);
        }

        //  self::generatePdf($beneficiary_owners_id);

        $id = $beneficiary_owners_id;
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');


        // $occupations = DB::table('occupations')
        // ->join('brokers','brokers.id','occupations.broker_id')
        // ->orderBy('occupations.id','DESC')
        // ->select('brokers.id','brokers.name AS broker_name','occupations.*')
        // ->get();

        $beneficiaryOwners = DB::table('beneficiary_owners')
            ->leftJoin('occupations', 'occupations.id', 'beneficiary_owners.occupation')
            ->leftJoin('country as present_country', 'present_country.id', 'beneficiary_owners.present_country')
            ->leftJoin('country as permanent_country', 'permanent_country.id', 'beneficiary_owners.permanent_country')
            ->where('beneficiary_owners.id', '=', $id)
            ->select('occupations.id', 'occupations.title AS occupation_title', 'beneficiary_owners.*','present_country.name AS present_country_name','permanent_country.name AS permanent_country_name')
            ->first();

        $beneficiary_authorizeds = DB::table('beneficiary_authorizeds')
            ->leftJoin('occupations', 'occupations.id', 'beneficiary_authorizeds.occupation')
            ->where('beneficiary_authorizeds.benificiary_owners_id', '=', $id)
            ->select('occupations.id', 'occupations.title AS occupation_title', 'beneficiary_authorizeds.*')
            ->first();

        $beneficiary_joint_holders = DB::table('beneficiary_joint_holders')
            ->leftJoin('occupations', 'occupations.id', 'beneficiary_joint_holders.occupation')
            ->where('beneficiary_joint_holders.benificiary_owners_id', '=', $id)
            ->select('occupations.id', 'occupations.title AS occupation_title', 'beneficiary_joint_holders.*')
            ->get();
        $bo_nominees = DB::table('bo_account_nominees')
            ->where('bo_account_nominees.benificiary_owners_id', '=', $id)
            ->leftJoin('relationships','relationships.id', 'bo_account_nominees.relationship_id')
            ->leftJoin('country','country.id', 'bo_account_nominees.country_id')
            ->leftJoin('occupations', 'occupations.id', 'bo_account_nominees.occupation')
            ->select('bo_account_nominees.*','relationships.title as relation','country.name as country','occupations.title AS occupation')
            ->get();



        $beneficiary_owners_banks = BeneficiaryOwnersBank::where('benificiary_owners_id', '=', $id)->first();

        $response = array(
            'data' => array(
                'beneficiaryOwners'             => $beneficiaryOwners,
                'beneficiary_authorizeds'       => $beneficiary_authorizeds,
                'beneficiary_joint_holders'     => $beneficiary_joint_holders,
                'beneficiary_owners_banks'      => $beneficiary_owners_banks,
                'bo_nominees'                   => $bo_nominees,
            ),
            'status' => 'success',
        );
        // dd($response);
        // define('DOMPDF_CHROOT', public_path());

        $pdf = Pdf::loadView('admin.beneficiary_owner.beneficiary_owners_pdf', compact('response'))->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'margin-top' => 0,
            'margin-right' => 0,
            'margin-bottom' => 0,
            'margin-left' => 0,
            'isRemoteEnabled' => false,
            'isPhpEnabled' => false,
            'isHtml5ParserEnabled' => false,
        ]);

        // Send email with PDF attachment
        Mail::to($beneficiaryOwners->email)->send(new BeneficiaryOwnersMail($pdf,$beneficiaryOwners));

        Session::flash('message', 'New Beneficiary Owners Create Successfully');
        Session::flash('id', $beneficiary_owners_id);
        return redirect()->route('beneficiary_owner.create');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BeneficiaryOwners  $beneficiaryOwners
     * @return \Illuminate\Http\Response
     */
    public function show(BeneficiaryOwners $beneficiaryOwners)
    {
        // $beneficiaryOwners = DB::table('beneficiary_owners')
        // ->join('brokers', 'brokers.id', 'beneficiary_owners.broker_id')
        // ->join('bo_categories', 'bo_categories.id', 'beneficiary_owners.bo_category_id ')
        // ->join('bo_types', 'bo_types.id', 'beneficiary_owners.bo_type_id')
        // ->where('beneficiary_owners.id', $beneficiaryOwners->id)
        // ->orderBy('beneficiary_owners.id', 'desc')
        // ->select(
        //     'employees.*',
        //     'brokers.id as broker_id',
        //     'brokers.name AS broker_name',
        //     'bo_categories.id as bo_categories_id',
        //     'bo_categories.title AS bo_categories_name',
        //     'bo_types.id as bo_types_id',
        //     'bo_types.title AS bo_types_name',
        // )
        // ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BeneficiaryOwners  $beneficiaryOwners
     * @return \Illuminate\Http\Response
     */
    public function edit(BeneficiaryOwners $beneficiary_owner)
    {
        // dd($beneficiary_owner);
        $countryes = DB::table('country')
            ->select('id', 'nicename')
            ->get()
            ->pluck('nicename', 'id')->prepend('Select Country', '');

        $IsYesNo = CommonController::isYesNo();
        $IsActive = CommonController::isActive();
        $StatementCycleCode = CommonController::statementCycleCode();
        $gender = CommonController::gender();
        // $occupation = CommonController::occupation();
        $occupation = Occupation::where(['is_active' => 1])->orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Occupation', '');
        $nationality = CommonController::nationality();
        $residency = CommonController::residency();
        $relation = CommonController::relation();
        $ifNomineeIsMinor = CommonController::ifNomineeIsMinor();
        $isExchangeListedCompany = CommonController::isExchangeListedCompany();
        $authorizationType = CommonController::authorizationType();
        $charges = Charge::where(['title' => 'Commission'])->orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Charge', '');
        $brokers = Broker::where(['is_active' => 1])->orderBY('name', 'asc')->get()->pluck('name', 'id')->prepend('Select Broker', '');
        $relationships = Relationship::where(['is_active' => 1])->orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Relation', '');
        $boCategoryId = BoCategory::where(['is_active' => 1])->orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Bo Category', '');
        $boTypeId = BoType::where(['is_active' => 1])->orderBY('title', 'asc')->get()->pluck('title', 'id')->prepend('Select Bo Type', '');
        $marginValue = Margin::where(['is_active' => 1])->orderBY('id', 'asc')->get()->pluck('title', 'id')->prepend('Select Margin Value', '');

        return view('admin.beneficiary_owner.form', with([
            'item' => $beneficiary_owner,
            'beneficiaryOwnersBank' => BeneficiaryOwnersBank::where('benificiary_owners_id', $beneficiary_owner->id)->first(),
            'beneficiaryAuthorized' => BeneficiaryAuthorized::where('benificiary_owners_id', $beneficiary_owner->id)->first(),
            'boAccountNominees' => BoAccountNominees::where('benificiary_owners_id', $beneficiary_owner->id)->get(),
            'beneficiaryJointHolders' => BeneficiaryJointHolders::where('benificiary_owners_id', $beneficiary_owner->id)->first(),
            'boCategoryId' => $boCategoryId,
            'boTypeId' => $boTypeId,
            'residency' => $residency,
            'nationality' => $nationality,
            'gender' => $gender,
            'occupation' => $occupation,
            'countryes' => $countryes,
            'relation' => $relation,
            'isExchangeListedCompany' => $isExchangeListedCompany,
            'isExchangeListedCompany' => $isExchangeListedCompany,
            'authorizationType' => $authorizationType,
            'ifNomineeIsMinor' => $ifNomineeIsMinor,
            'brokers' => $brokers,
            'IsYesNo' => $IsYesNo,
            'IsActive' => $IsActive,
            'StatementCycleCode' => $StatementCycleCode,
            'relationships' => $relationships,
            'charges' => $charges,
            'marginValue' => $marginValue,
        ]));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BeneficiaryOwners  $beneficiaryOwners
     * @return \Illuminate\Http\Response
     */
    public function update(BeneficiaryOwnersRequest $request, BeneficiaryOwners $beneficiary_owner)
    {
        // dd($beneficiary_owner);
        // return $request->all();
        $beneficiary_owners_id = $beneficiary_owner->id;
        BeneficiaryOwners::updateBeneficiaryOwners($request, $beneficiary_owner);
        BeneficiaryAuthorized::updateBeneficiaryAuthorized($request, $beneficiary_owners_id);
        BeneficiaryJointHolders::updateBeneficiaryJointHolders($request, $beneficiary_owners_id);
        BeneficiaryOwnersBank::updateBeneficiaryOwnersBank($request, $beneficiary_owners_id);
        BoAccountNominees::updateBoAccountNominees($request, $beneficiary_owners_id);
        return redirect()->route('beneficiary_owner.index')->with('status', 'Beneficiary Owner Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BeneficiaryOwners  $beneficiaryOwners
     * @return \Illuminate\Http\Response
     */
    public function destroy(BeneficiaryOwners $beneficiary_owner)
    {
        $beneficiary_owner->delete();
        return redirect()->back()->with('status', 'Beneficiary Owner Delete Successfully');
    }

    public function generatePdf($id)
    {
        $id = $id;
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');


        // $occupations = DB::table('occupations')
        // ->join('brokers','brokers.id','occupations.broker_id')
        // ->orderBy('occupations.id','DESC')
        // ->select('brokers.id','brokers.name AS broker_name','occupations.*')
        // ->get();

        $beneficiaryOwners = DB::table('beneficiary_owners')
            ->leftJoin('occupations', 'occupations.id', 'beneficiary_owners.occupation')
            ->leftJoin('country as present_country', 'present_country.id', 'beneficiary_owners.present_country')
            ->leftJoin('country as permanent_country', 'permanent_country.id', 'beneficiary_owners.permanent_country')
            ->where('beneficiary_owners.id', '=', $id)
            ->select('occupations.id', 'occupations.title AS occupation_title', 'beneficiary_owners.*','present_country.name AS present_country_name','permanent_country.name AS permanent_country_name')
            ->first();

        $beneficiary_authorizeds = DB::table('beneficiary_authorizeds')
            ->leftJoin('occupations', 'occupations.id', 'beneficiary_authorizeds.occupation')
            ->where('beneficiary_authorizeds.benificiary_owners_id', '=', $id)
            ->select('occupations.id', 'occupations.title AS occupation_title', 'beneficiary_authorizeds.*')
            ->first();

        $beneficiary_joint_holders = DB::table('beneficiary_joint_holders')
            ->leftJoin('occupations', 'occupations.id', 'beneficiary_joint_holders.occupation')
            ->where('beneficiary_joint_holders.benificiary_owners_id', '=', $id)
            ->select('occupations.id', 'occupations.title AS occupation_title', 'beneficiary_joint_holders.*')
            ->get();
        $bo_nominees = DB::table('bo_account_nominees')
            ->where('bo_account_nominees.benificiary_owners_id', '=', $id)
            ->leftJoin('relationships','relationships.id', 'bo_account_nominees.relationship_id')
            ->leftJoin('country','country.id', 'bo_account_nominees.country_id')
            ->leftJoin('occupations', 'occupations.id', 'bo_account_nominees.occupation')
            ->select('bo_account_nominees.*','relationships.title as relation','country.name as country','occupations.title AS occupation')
            ->get();



        $beneficiary_owners_banks = BeneficiaryOwnersBank::where('benificiary_owners_id', '=', $id)->first();

        $response = array(
            'data' => array(
                'beneficiaryOwners'             => $beneficiaryOwners,
                'beneficiary_authorizeds'       => $beneficiary_authorizeds,
                'beneficiary_joint_holders'     => $beneficiary_joint_holders,
                'beneficiary_owners_banks'      => $beneficiary_owners_banks,
                'bo_nominees'                   => $bo_nominees,
            ),
            'status' => 'success',
        );
        // dd($response);
        // define('DOMPDF_CHROOT', public_path());

        $pdf = Pdf::loadView('admin.beneficiary_owner.beneficiary_owners_pdf', compact('response'));
        $pdf = Pdf::loadView('admin.beneficiary_owner.beneficiary_owners_pdf', compact('response'))->setPaper('a4', 'portrait');

        $pdf->setOptions([
            'margin-top' => 0,
            'margin-right' => 0,
            'margin-bottom' => 0,
            'margin-left' => 0,
            'isRemoteEnabled' => false,
            'isPhpEnabled' => false,
            'isHtml5ParserEnabled' => false,
        ]);
        // return view('admin.beneficiary_owner.beneficiary_owners_pdf', compact('response'));

        Session::flash('stopspin', '1');
        $filename = 'Beneficiary-' . $beneficiaryOwners->name . '-' . $beneficiaryOwners->id . '.pdf';
        return $pdf->download($filename);

        // $headers = [
        //     'Content-Type' => 'application/pdf',
        //     'Content-Disposition' => 'inline; filename="beneficiary-owners(BO).pdf"',
        // ];

        // return Response::make($pdf->output(), 200, $headers);

    }
    public function downloadPdf()
    {
        $data = 'aaaa';
        $pdf = Pdf::loadView('admin.beneficiary_owner.beneficiary_owners_pdf', compact('data'));
        return $pdf->download('beneficiary-owners(BO).pdf');
    }
}
