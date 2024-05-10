<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissionmod extends Model
{
    use HasFactory;

    protected $fillable = ['name','label_name','guard_name','created_at','updated_at'];

    protected $table = 'permissions';
    
    public static function boot()
    {
        parent::boot();
        Static::creating(function ($model) {
            // $model->created_by =  Auth()->user()->id;
        });
        Static::updating(function ($model) {
            // $model->updated_by =  Auth()->user()->id;
        });
    }
}
