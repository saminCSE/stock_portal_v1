<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPortal extends Model
{
    use HasFactory;
    protected $table = 'news_portal';
    protected $fillable = ['id','news_category','title','slug','published_date','short_description','long_description','is_published','source','source_link','file','created_by','created_at','updated_by','updated_at'];
}
