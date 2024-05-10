<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenStatistic extends Model
{
    use HasFactory;


       /**
     * The fillable values
     * 
     * @var array
     */
    protected $fillable = [
        'date',
        'success',
        'ip_address',
        'token_id',
        'request',
    ];

    /**
     * Casting array
     *
     * @var array
     */
    protected $casts = [
        'success' => 'bool',
        'request' => 'collection',
    ];

    /**
     * Doesn't have timestamps
     *
     * @var bool
     */
    public $timestamps = false;
}
