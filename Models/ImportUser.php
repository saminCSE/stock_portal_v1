<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ImportUser extends Model
{
    use HasFactory;

    protected $table="data_banks_eods";
    public $timestamps =false;
    protected $fillable=['market_id','instrument_id','open','high','low','close','volume','trade','tradevalues','date','updated','market_instrument','batch'];
    
    public static function getUser()
    {      
            $records=DB::table('data_banks_eods')
            ->select('market_id','instrument_id','open','high','low','close','volume','trade','tradevalues','date','updated','market_instrument','batch');
           // dd($records);
            return $records;
    }
}
