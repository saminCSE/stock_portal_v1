<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    // protected $guarded = [];
    protected $table = 'stores';
    protected $fillable = ['code','name','office_id','store_location','contact_person','phone','email','active_status','created_by','created_at','updated_by','updated_at'];


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

    public function office(){
        return $this->belongsTo(Office::class, 'office_id','id');
    }
}
