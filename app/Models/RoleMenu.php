<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use HasFactory;

    
    protected $fillable = ['id','role_id','menu_id','created_by','created_at','updated_by','updated_at'];

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

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id','id');
    }
    public function role() {
        return $this->belongsTo(Role::class, 'role_id','id');
    }
}
