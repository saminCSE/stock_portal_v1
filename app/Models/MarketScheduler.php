<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class MarketScheduler extends Model
{
    //protected $table = '';
    protected $guarded = [];
    public $appends = ['date_time_open','date_time_close'];

    public static function boot()
    {
        parent::boot();
        Static::creating(function ($model) {
           $model->created_at = Carbon::now();
        });
        // Static::updating(function ($model) {
        //   //  $model->updated_by =  auth()->user()->id;
            
        // });
    }

    
    public function getDateTimeOpenAttribute()
    {
        return "{$this->open_date} {$this->open_time}";
    }
    public function getDateTimeCloseAttribute()
    {
        return "{$this->open_date} {$this->close_time}";
    }


   
    
}
