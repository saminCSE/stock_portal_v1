<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['open_date','open_time','close_date','status','close_time','comments','created_by','updated_by',];
}
