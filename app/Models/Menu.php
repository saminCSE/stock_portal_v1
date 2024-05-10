<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_name','slug','icon_id','parent_id','is_active','orderno','project_no','created_by','created_at','updated_by','updated_at'];

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

    public function getParentMenu() {
        return $this->belongsTo(self::class, 'parent_id','id');
    }
}
