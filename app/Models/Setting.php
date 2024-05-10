<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;



    protected $fillable = ['brand_name','address','phone','email','logo','favicon','fb_link','twitter_link','youtube_link','instagram_link','menu_id','linkedin','google_recaptcha_site_key','mail_to'];

    public function getLogoAttribute($value)
    {
        return asset($value);
    }

    public function getFaviconAttribute($value)
    {
        return asset($value);
    }
}
