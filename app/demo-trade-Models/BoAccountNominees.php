<?php

namespace App\Models;

use App\Repositories\ImageUploadRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoAccountNominees extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = 1;
            $model->created_at = Date('Y-m-d H:i:s');
        });
        static::updating(function ($model) {
            $model->updated_by = 1;
            $model->updated_at = Date('Y-m-d H:i:s');
        });
    }

    public static function BasicInfo($request, $beneficiary_owners_id)
    {
        $nominee = $request->nominee_name;
        $basicInfoArray = array(); // Initialize empty array
        foreach ($nominee as $key => $value) {
            $basicInfoArray[$key] = array(
                'broker_id' => $request->broker_id,
                'benificiary_owners_id' => $beneficiary_owners_id,
                'relationship_id' => $request->relationship_id[$key],
                'name' => $request->nominee_name[$key],
                'fathers_name' => $request->nominee_father_name[$key],
                'mothers_name' => $request->nominee_mother_name[$key],
                'spouse_name' => $request->nominee_spouse_name[$key],
                'percentage' => $request->percentage[$key],
                'date_of_birth' => $request->nominee_date_of_birth[$key],
                'gender' => $request->nominee_gender[$key],
                'country_id' => $request->nominee_country_id[$key],
                'mobile' => $request->nominee_mobile[$key],
                'telephone' => $request->nominee_telephone[$key],
                'email' => $request->nominee_email[$key],
                'present_address' => $request->nominee_present_address[$key],
                'permanent_address' => $request->nominee_permanent_address[$key],
                'residency_status' => $request->nominee_residency[$key],
                'occupation' => $request->nominee_occupation[$key],
                'nid' => $request->nominee_nid[$key],
                'passport_no' => $request->nominee_passport_no[$key],
                'passport_issue_place' => $request->nominee_passport_issue_place[$key],
                'passport_issue_date' => $request->nominee_passport_issue_date[$key],
                'passport_expiry_date' => $request->nominee_passport_expiry_date[$key],
                // 'is_minor'                   => $request->if_nominee_is_minor[$key],
                // 'guardian_full_name'         => $request->nominee_guardian_full_name[$key],
                // 'guardian_name_short'        => $request->nominee_guardian_name_short[$key],
            );
            // if ($request->hasFile("nominees_image[$key]")) {
            //     $image = $request->file("nominees_image[$key]");
            //     $path = public_path() . "/uploads/BO";
            //     $nominees_image = ImageUploadRepo::uploadImage($path, $image, '300-300');
            //     $basicInfoArray[$key]['nominees_image'] = $nominees_image ? $nominees_image : null;
            // }
        }

        if (isset($request->nominees_image)) {
            foreach ($request->file('nominees_image') as $key => $imagefile) {
                $image = $imagefile;
                $path = public_path() . "/uploads/BO/";
                $nominees_image = ImageUploadRepo::uploadImage($path, $image, '300-300');
                $basicInfoArray[$key]['nominees_image'] = $nominees_image ? $nominees_image : null;
            }
        }

        if (isset($request->nominees_sign)) {
            foreach ($request->file('nominees_sign') as $key => $imagefile) {
                $image = $imagefile;
                $path = public_path() . "/uploads/BO/";
                $nominees_sign = ImageUploadRepo::uploadImage($path, $image, '300-300');
                $basicInfoArray[$key]['nominees_sign'] = $nominees_sign ? $nominees_sign : null;
            }
        }

        if (isset($request->nominees_nid)) {
            foreach ($request->file('nominees_nid') as $key => $imagefile) {
                $image = $imagefile;
                $path = public_path() . "/uploads/BO/";
                $nominees_nid = ImageUploadRepo::uploadImage($path, $image, '300-300');
                $basicInfoArray[$key]['nominees_nid'] = $nominees_nid ? $nominees_nid : null;
            }
        }


        return $basicInfoArray;
    }

    public static function storeBoAccountNominees($request, $beneficiary_owners_id)
    {
        $saveBasicInfo = self::BasicInfo($request, $beneficiary_owners_id);
        self::insert($saveBasicInfo);
    }

    public static function updateBoAccountNominees($request, $beneficiary_owners_id)
    {
        // $boAccountNominees = BoAccountNominees::where('benificiary_owners_id', $beneficiary_owners_id)->get();

        $nominee = $request->nominee_id;
        $basicInfoArray = array(); // Initialize empty array
        foreach ($nominee as $key => $value) {
            $basicInfoArray = array(
                'broker_id' => $request->broker_id,
                'benificiary_owners_id' => $beneficiary_owners_id,
                'relationship_id' => $request->relationship_id[$key],
                'name' => $request->nominee_name[$key],
                'fathers_name' => $request->nominee_father_name[$key],
                'mothers_name' => $request->nominee_mother_name[$key],
                'spouse_name' => $request->nominee_spouse_name[$key],
                'percentage' => $request->percentage[$key],
                'date_of_birth' => $request->nominee_date_of_birth[$key],
                'gender' => $request->nominee_gender[$key],
                'country_id' => $request->nominee_country_id[$key],
                'mobile' => $request->nominee_mobile[$key],
                'telephone' => $request->nominee_telephone[$key],
                'email' => $request->nominee_email[$key],
                'present_address' => $request->nominee_present_address[$key],
                'permanent_address' => $request->nominee_permanent_address[$key],
                'residency_status' => $request->nominee_residency[$key],
                'occupation' => $request->nominee_occupation[$key],
                'nid' => $request->nominee_nid[$key],
                'passport_no' => $request->nominee_passport_no[$key],
                'passport_issue_place' => $request->nominee_passport_issue_place[$key],
                'passport_issue_date' => $request->nominee_passport_issue_date[$key],
                'passport_expiry_date' => $request->nominee_passport_expiry_date[$key],
                // 'is_minor'                   => $request->if_nominee_is_minor[$key],
                // 'guardian_full_name'         => $request->nominee_guardian_full_name[$key],
                // 'guardian_name_short'        => $request->nominee_guardian_name_short[$key],
            );





            if (($request->nominee_id[$key]) == '') {
                BoAccountNominees::insert($basicInfoArray);
            } else {
                $boNominees = BoAccountNominees::find($request->nominee_id[$key]);
                $boNominees->update($basicInfoArray);
            }
        }
    }

}
