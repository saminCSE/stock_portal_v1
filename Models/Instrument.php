<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'instruments';
    protected $fillable = ['id', 'exchange_id', 'sector_list_id', 'instrument_code', 'isin', 'name', 'is_spot', 'active', 'batch_id', 'market_id'];
}
