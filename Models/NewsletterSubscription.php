<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    use HasFactory;
    protected $table = 'news_letter';
    protected $fillable = ['id','email','created_at','updated_at'];
}
