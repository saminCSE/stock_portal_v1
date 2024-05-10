<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ImportBlockTransaction extends Model
{
    use HasFactory;

    protected $table="block_transactions";
    public $timestamps =false;
    protected $fillable=['instrument_id','quantity','value','trades','max_price','min_price','transaction_date'];
    
    public static function getUser()
    {      
            $records=DB::table('block_transactions')
            ->select('instrument_id','quantity','value','trades','max_price','min_price','transaction_date');
            return $records;
    }
}
