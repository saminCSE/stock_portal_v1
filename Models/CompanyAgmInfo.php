<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAgmInfo extends Model
{
    use HasFactory;
    protected $table = 'company_agm_information';
    protected  $fillable=['id'];
    protected $guarded = [];
}
