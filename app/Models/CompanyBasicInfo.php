<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBasicInfo extends Model
{
    use HasFactory;
    protected $table = 'company_basic_information';
    protected $guarded = [];

}
