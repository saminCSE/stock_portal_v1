<?php
// https://reecemay.me/articles/custom_token_authentication_for_laravel/
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'active_status',
        'role_id',
        'office_id',
        'store_id'
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function role(){
        return $this->belongsTo(Role::class, 'role_id','id');
    }
    public function office(){
        return $this->belongsTo(Office::class, 'office_id','id');
    }
    public function store(){
        return $this->belongsTo(Store::class, 'store_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class, 'id','user_id');
    }
    public function issueapprovalemployee(){
        return $this->belongsTo(Employee::class,'id','user_id');
    }
}
