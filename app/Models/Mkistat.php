<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mkistat extends Model
{
    protected $table = 'mkistat';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        Static::creating(function ($model) {
          //  $model->created_by =  auth()->user()->id;
         
        });
        Static::updating(function ($model) {
          //  $model->updated_by =  auth()->user()->id;
            
        });
    }

    // public function employee(){
    //     return $this->belongsTo(Employee::class, 'employee_id','id');
    // }
   
    // public function loan() {
    //     return $this->belongsTo(EmployeeLoanBalance::class, 'id','employee_id')->where('type','!=','1');;
    // }



   
    
}
