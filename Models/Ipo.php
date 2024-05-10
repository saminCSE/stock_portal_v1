<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipo extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'ipo';
    protected $fillable = ['id', 'name', 'board', 'asset_class', 'methods', 'status', 'Open_date', 'close_date', 'ipo_size', 'offer_price','summary','prospectors','results'];
}
