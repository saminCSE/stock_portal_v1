<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectorProfile extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public static function boot()
    {
        parent::boot();
        Static::creating(function ($model) {
            $model->created_by =  auth()->user()->id;
            $model->created_at = Date('Y-m-d H:i:s');
        });
        Static::updating(function ($model) {
            $model->updated_by =  auth()->user()->id;
            $model->updated_at =  Date('Y-m-d H:i:s');
        });
    }
}
