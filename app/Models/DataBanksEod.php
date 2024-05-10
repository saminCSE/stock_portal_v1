<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataBanksEod extends Model
{
    
    protected $guarded = [];
    public $timestamps = false;
    
    public function instrument(){
        return $this->belongsTo(Instrument::class, 'instrument_id','id');
    }


    public static function  getSingleHistoryData($data) {
        return DataBanksEod::select('*',DB::raw('UNIX_TIMESTAMP(date) as unix_lm_date_time'))
                       ->where('date','<',$data['from_date'])
                       ->where('instrument_id',$data['instrument_id'])
                       ->first();
    }
}
