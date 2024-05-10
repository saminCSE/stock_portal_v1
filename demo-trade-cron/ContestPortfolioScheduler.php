<?php

namespace App\Http\Controllers\cron;

use App\Http\Controllers\Controller;
use App\Models\ContestOrder;
use App\Models\ProductOrder;
use Illuminate\Http\Request;

class ContestPortfolioScheduler extends Controller
{
    public function pendingHoldingChange() {

        $collect = ContestOrder::where(["is_measure"=>0,"side"=>'B'])->get();
//         echo '<pre>';
// print_r($collect);
// exit;
        foreach($collect as $row){
            $product = array(
                'id'=>$row->id,
                'contests_id'=>$row->contests_id,
                'portal_user_id'=>$row->portal_user_id,
                'instrument_code'=>$row->instrument_code,
                'quantity'=>$row->quantity,
                'price'=>$row->price,
                'value'=>$row->value,
                'side'=>$row->side,
                'board'=>$row->board,
                'category'=>$row->category,
                'purchase_date'=>$row->purchase_date,
            );
            ContestOrder::changeUnMeasuredRecord($product);
        }

    }
}
