<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roleHasPermission extends Model
{
    use HasFactory;
    protected $fillable = ['permission_id','role_id'];
    public $timestamps = false;

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


    public function permission() {
        return $this->belongsTo(Permissionmod::class, 'permission_id','id');
    }
    public function role() {
        return $this->belongsTo(Role::class, 'role_id','id');
    }

}
