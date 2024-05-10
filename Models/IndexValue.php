<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IndexValue extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function instrument(){
        return $this->belongsTo(Instrument::class, 'instrument_id','id');
    }
    public function getIndexDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
