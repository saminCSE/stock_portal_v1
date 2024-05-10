<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['store_id','item_id','stock_quantity','do_quantity','updated_by','updated_at'];
    
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        Static::creating(function ($model) {
           
            $model->updated_by =  Auth()->user()->id;
            $model->updated_at =  date('Y-m-d H:i:s');
        });
        Static::updating(function ($model) {
            $model->updated_by =  Auth()->user()->id;
            $model->updated_at =  date('Y-m-d H:i:s');
        });
    }

    public function item(){
        return $this->belongsTo(Item::class, 'item_id','id');
    }

    public function store(){
        return $this->belongsTo(Store::class, 'store_id','id');
    }
    public function acquistionitem() {
        return $this->belongsTo(AcquisitionItem::class,'item_id','item_id');
    }
}
