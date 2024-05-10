<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['id','employee_id','grade_id','scale_id','execute_date','is_last_promotion','created_by','created_at','updated_by','updated_at'];

    public static function boot()
    {
        parent::boot();
        Static::creating(function ($model) {
            $model->created_by =  auth()->user()->id;
            $model->is_last_promotion =  1;
        });
        Static::updating(function ($model) {
            $model->updated_by =  auth()->user()->id;
        });
    }

    public function grade(){
        return $this->belongsTo(Grade::class, 'grade_id','id');
    }
    public function scale(){
        return $this->belongsTo(Scale::class, 'scale_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id','id');
    }
    
}
