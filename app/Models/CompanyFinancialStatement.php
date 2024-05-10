<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyFinancialStatement extends Model
{
    use HasFactory;
    protected $fillable = [
        'instrument_id',
        'date_time',
        'quatar_text',
        'is_active',
        'file',
    ];
}
