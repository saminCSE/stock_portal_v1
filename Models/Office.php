<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['name','phone','email','address','active_status','created_by','created_at','updated_by','updated_at'];

    public static function boot()
    {
        parent::boot();
        Static::creating(function ($model) {
            $model->created_by =  Auth()->user()->id;
        });
        Static::updating(function ($model) {
            $model->updated_by =  Auth()->user()->id;
        });
    }
}
