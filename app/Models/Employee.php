<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        Static::creating(function ($model) {
            $model->created_by =  auth()->user()->id;
         
        });
        Static::updating(function ($model) {
            $model->updated_by =  auth()->user()->id;
            
        });
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id','id');
    }
    public function designation() {
        return $this->belongsTo(Designation::class, 'present_designation_id','id');
    }
    public function salarysetup() {
        return $this->belongsTo(SalarySetup::class, 'id','employee_id');
    }
    public function openingloan() {
        return $this->belongsTo(EmployeeLoanBalance::class, 'id','employee_id')->where('type','1');;
    }
    public function loan() {
        return $this->belongsTo(EmployeeLoanBalance::class, 'id','employee_id')->where('type','!=','1');;
    }

    public function year() {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year','id');
    }
    public function month() {
        return $this->belongsTo(FiscalMonth::class, 'fiscal_month','id');
    }
    public function department() {
        return $this->belongsTo(Department::class, 'department_id','id');
    }
    public function promotion() {
        return $this->belongsTo(Promotion::class,'id','employee_id');
    }

   
    
}
