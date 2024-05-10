<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BeneficiaryOwnersBank;

class BenificiaryOwnerController extends Controller
{
    public function list(){
        $bos = DB::table('beneficiary_owners')->get();
        return view('admin.bo.list',compact('bos'));
    }
    public function generatePdf($id)
    {
        $id = $id;


        // $occupations = DB::table('occupations')
        // ->join('brokers','brokers.id','occupations.broker_id')
        // ->orderBy('occupations.id','DESC')
        // ->select('brokers.id','brokers.name AS broker_name','occupations.*')
        // ->get();

        $beneficiaryOwners = DB::table('beneficiary_owners')
            ->leftJoin('occupations', 'occupations.id', 'beneficiary_owners.occupation')
            ->where('beneficiary_owners.id', '=', $id)
            ->select('occupations.id', 'occupations.title AS occupation_title', 'beneficiary_owners.*')
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


        $beneficiary_owners_banks = BeneficiaryOwnersBank::where('benificiary_owners_id', '=', $id)->first();

        $response = array(
            'data' => array(
                'beneficiaryOwners'             => $beneficiaryOwners,
                'beneficiary_authorizeds'       => $beneficiary_authorizeds,
                'beneficiary_joint_holders'     => $beneficiary_joint_holders,
                'beneficiary_owners_banks'      => $beneficiary_owners_banks,
            ),
            'status' => 'success',
        );
        // dd($response);
        // define('DOMPDF_CHROOT', public_path());

        // $pdf = Pdf::loadView('admin.beneficiary_owner.beneficiary_owners_pdf', compact('response'));
        $pdf = Pdf::loadView('admin.bo.bo_pdf', compact('response'))->setPaper('a4', 'portrait');

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

        return $pdf->download('beneficiary-owners(BO).pdf');

    }
}
