<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestaps=true;
    // public static function boot()
    // {
    //     parent::boot();
    //     Static::creating(function ($model) {
    //         $model->created_by = Auth()->user()->id;
    //     });
    //     Static::updating(function ($model) {
    //         $model->updated_by = Auth()->user()->id;
    //     });
    // }
}
