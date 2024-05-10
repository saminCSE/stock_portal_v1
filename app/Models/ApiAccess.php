<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiAccess extends Model
{
    use HasFactory;
    protected $table = 'api_access';
    protected $fillable = ['username', 'password','status'];
}
