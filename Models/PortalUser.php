<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PortalUser extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $table = 'portal_user';
    protected $fillable = [
        'full_name',
        'email',
        'mobile',
        'password',
        'ip_address',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->user()->id;
            }
        });
        static::updating(function ($model) {
            if (auth()->check()) {
            $model->updated_by = auth()->user()->id;
            }
        });
    }
}
