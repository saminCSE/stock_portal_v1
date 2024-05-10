<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBanksIntraday extends Model
{
    //protected $table = 'mkistat';
    protected $guarded = [];
    public $timestamps = false;

    // public static function boot()
    // {
    //     parent::boot();
    //     Static::creating(function ($model) {
    //        $model->created_by =  auth()->user()->id;
         
    //     });
    //     Static::updating(function ($model) {
    //        $model->updated_by =  auth()->user()->id;
            
    //     });
    // }

    public function instrument(){
        return $this->belongsTo(Instrument::class, 'instrument_id','id');
    }
}
