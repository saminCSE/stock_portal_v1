<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryAuthorized extends Model
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
        $basicInfoArray = array(
            'broker_id'                 => $request->broker_id,
            'benificiary_owners_id'     => $beneficiary_owners_id,
            'name'                      => $request->authorized_person_name,
            'fathers_name'              => $request->authorized_person_father_name,
            'mothers_name'              => $request->authorized_person_mother_name,
            'spouse_name'               => $request->authorized_person_spouse_name,
            'date_of_birth'             => $request->authorized_person_birth,
            'gender'                    => $request->authorized_person_gender,
            'country_id'                => $request->authorized_person_present_country,
            'present_address'           => $request->authorized_person_present_address,
            'permanent_address'         => $request->authorized_person_permanent_address,
            'mobile'                    => $request->authorized_person_mobile,
            'telephone'                 => $request->authorized_person_telephone,
            'email'                     => $request->authorized_person_email,
            'e_tin'                     => $request->authorized_person_tin,
            'nid'                       => $request->authorized_person_nid,
            'occupation'                => $request->authorized_person_occupation,
            'nationality'               => $request->authorized_person_nationality,
            'residency'                 => $request->authorized_person_residency,
            'listed_company'            => $request->is_exchange_listed_company,
            'stock_exchange_name'       => $request->stock_exchange_name,
            'authorization_type'        => $request->authorization_type,
           
        );
        return $basicInfoArray;
       }

    public static function storeBeneficiaryAuthorized($request,$beneficiary_owners_id){
       $saveBasicInfo= self::BasicInfo($request,$beneficiary_owners_id);
       self::create($saveBasicInfo);
    }
 
    public static function updateBeneficiaryAuthorized($request, $beneficiary_owners_id){
        $beneficiaryAuthorized = BeneficiaryAuthorized::where('benificiary_owners_id', $beneficiary_owners_id)->first();
        $saveBasicInfo = self::BasicInfo($request, $beneficiary_owners_id);
        $beneficiaryAuthorized->update($saveBasicInfo);
    }
    
}
