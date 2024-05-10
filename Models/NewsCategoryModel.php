<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'news_category';
    protected $fillable = ['id', 'name','IsActive','created_by','created_at','updated_by','updated_at'];
}
