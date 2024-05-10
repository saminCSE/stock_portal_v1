<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    // use HasFactory;
    protected $table = 'news';
    protected $guarded = [];
    protected $fillable = ['id','market_id','instrument_id','prefix','title','details','post_date','expire_date','is_active','updated'];
}
