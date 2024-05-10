<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryJointHolders extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public static function boot()
    {
        parent::boot();
        Static::creating(function ($model) {
            $model->created_by =  1;
            $model->created_at = Date('Y-m-d H:i:s');
        });
        Static::updating(function ($model) {
            $model->updated_by =  1;
            $model->updated_at =  Date('Y-m-d H:i:s');
        });
    }
    public static function BasicInfo($request,$beneficiary_owners_id){

        // dd($request);
        $basicInfoArray = array(
            'broker_id'                 => $request->broker_id,
            'benificiary_owners_id'     => $beneficiary_owners_id,
            'name'                      => $request->joint_person_name,
            'fathers_name'              => $request->joint_person_father_name,
            'mothers_name'              => $request->joint_person_mother_name,
            'spouse_name'               => $request->joint_person_spouse_name,
            'date_of_birth'             => $request->joint_person_birth,
            'gender'                    => $request->joint_person_gender,
            'country_id'                => $request->joint_person_present_country,
            'present_address'           => $request->joint_person_present_address,
            'permanent_address'         => $request->joint_person_permanent_address,
            'mobile'                    => $request->joint_person_mobile,
            'telephone'                 => $request->joint_person_telephone,
            'email'                     => $request->joint_person_email,
            'e_tin'                     => $request->joint_person_tin,
            'nid'                       => $request->joint_person_nid,
            'occupation'                => $request->joint_person_occupation, 
        );

        // dd($basicInfoArray);
        return $basicInfoArray;
       }

    public static function storeBeneficiaryJointHolders($request,$beneficiary_owners_id){
       $saveBasicInfo= self::BasicInfo($request,$beneficiary_owners_id);
       self::create($saveBasicInfo);
    }
    public static function updateBeneficiaryJointHolders($request, $beneficiary_owners_id){
        $beneficiaryJointHolders = BeneficiaryJointHolders::where('benificiary_owners_id', $beneficiary_owners_id)->first();
    //    dd($beneficiaryJointHolders);
        $saveBasicInfo = self::BasicInfo($request, $beneficiary_owners_id);
        $beneficiaryJointHolders->update($saveBasicInfo);
    }
}
