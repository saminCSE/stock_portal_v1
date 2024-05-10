<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryOwnersBank extends Model
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
            'broker_id'                       => $request->broker_id,
            'benificiary_owners_id'           => $beneficiary_owners_id,
            'branch_name'                     => $request->branch_name,
            'bank_name'                     => $request->bank_name,
            'account_no'                      => $request->account_no,
            'routing_no'                      => $request->routing_no,
            'is_electronic_divident_credit'   => $request->is_electronic_divident_credit,
            'is_tax_exemption'                => $request->is_tax_exemption,
            'is_tax_exemption'                => $request->is_tax_exemption,
        );
        return $basicInfoArray;
       }

    public static function storeBeneficiaryOwnersBank($request,$beneficiary_owners_id){
       $saveBasicInfo= self::BasicInfo($request,$beneficiary_owners_id);
       self::create($saveBasicInfo);
    }
    
    public static function updateBeneficiaryOwnersBank($request, $beneficiary_owners_id){
        $beneficiaryOwnersBank = BeneficiaryOwnersBank::where('benificiary_owners_id', $beneficiary_owners_id)->first();
        $saveBasicInfo = self::BasicInfo($request, $beneficiary_owners_id);
        $beneficiaryOwnersBank->update($saveBasicInfo);
    }
}