<?php

namespace App\Models;

use App\Repositories\ImageUploadRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BeneficiaryOwners extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by =  1;
            $model->created_at = Date('Y-m-d H:i:s');
        });
        static::updating(function ($model) {
            $model->updated_by =  1;
            $model->updated_at =  Date('Y-m-d H:i:s');
        });
    }

    public static function BasicInfo($request)
    {




        $basicInfoArray = array(
            'broker_id'                     => $request->broker_id,
            'bo_category_id'                => $request->bo_category_id,
            'bo_type_id'                    => $request->bo_type_id,
            'bo_id'                         => $request->bo_id,
            'name'                          => $request->name,
            'father_name'                   => $request->father_name,
            'mother_name'                   => $request->mother_name,
            'spouse_name'                   => $request->spouse_name,
            'date_of_birth'                 => $request->date_of_birth,
            'gender'                        => $request->gender,
            'mobile'                        => $request->mobile,
            'telephone'                     => $request->telephone,
            'email'                         => $request->email,
            'e_tin'                         => $request->e_tin,
            'nid'                           => $request->nid,
            'occupation'                    => $request->occupation,
            'is_joint_account'              => $request->is_joint_account,
            'present_address'               => $request->present_address,
            'present_country'               => $request->present_country,
            'present_division'              => $request->present_division,
            'present_city'                  => $request->present_city,
            'present_postcode'              => $request->present_postcode,
            'permanent_address'             => $request->permanent_address,
            'permanent_country'             => $request->permanent_country,
            'permanent_division'            => $request->permanent_division,
            'permanent_city'                => $request->permanent_city,
            'permanent_postcode'            => $request->permanent_postcode,
            'passport_no'                   => $request->passport_no,
            'passport_issue_place'          => $request->passport_issue_place,
            'passport_issue_date'           => $request->passport_issue_date,
            'passport_expiry_date'          => $request->passport_expiry_date,
            'date_of_registration'          => $request->date_of_registration,
            'is_account_link_request'       => $request->is_account_link_request,
            'account_link_bo_ac_code'        => $request->account_link_bo_ac_code,
            'residency_status'              => $request->residency_status,
            // 'nationality'                    => $request->nationality,
            // 'is_active'                     => $request->is_active,
            // 'charges_id'                    => $request->charges_id,
            'introducer_code'               => $request->introducer_code,
            'introducer_name'               => $request->introducer_name,
            'introducer_phone'              => $request->introducer_phone,
            'introducer_email'              => $request->introducer_email,



        );
        if ($request->hasFile('applicants_image')) {
            $image = $request->applicants_image;
            $path = public_path() . "/uploads/BO";
            $applicants_image = ImageUploadRepo::uploadImage($path, $image, '300-300');
            $basicInfoArray['applicants_image'] = $applicants_image?$applicants_image:null;
        }



        if ($request->hasFile('applicants_sign')) {
            $image = $request->applicants_sign;
            $path = public_path() . "/uploads/BO/";
            $applicants_sign = ImageUploadRepo::uploadImage($path, $image, '300-80');
            $basicInfoArray['applicants_sign'] = $applicants_sign?$applicants_sign:null;
        }


        if ($request->hasFile('applicants_nid')) {
            $image = $request->applicants_nid;
            $path = public_path() . "/uploads/BO/";
            $applicants_nid = ImageUploadRepo::uploadImage($path, $image, '300-300');
            $basicInfoArray['applicants_nid'] = $applicants_nid?$applicants_nid:null;
        }

        if ($request->hasFile('applicants_bank_check')) {
            $image = $request->applicants_bank_check;
            $path = public_path() . "/uploads/BO/";
            $applicants_bank_check = ImageUploadRepo::uploadImage($path, $image, '300-300');
            $basicInfoArray['applicants_bank_check'] = $applicants_bank_check?$applicants_bank_check:null;
        }


        return $basicInfoArray;
    }

    public static function storeBeneficiaryOwners($request)
    {
        $saveBasicInfo = self::BasicInfo($request);
        $beneficiaryOwners = self::create($saveBasicInfo);
        return $beneficiaryOwners->id;
    }

    public static function updateBeneficiaryOwners($request, $beneficiary_owner)
    {
        $saveBasicInfo = self::BasicInfo($request);
        $beneficiary_owner->update($saveBasicInfo);
    }

    public function charge()
    {
        return $this->belongsTo(Charge::class, 'charges_id', 'id')->select('id','broker_id','title','value');
    }
}
