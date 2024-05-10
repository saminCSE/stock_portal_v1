<?php

namespace App\Imports;

use App\Models\BlockTransaction;
use App\Models\ImportBlockTransaction;
use App\Models\Instrument;
use Illuminate\Bus\Batch;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class BlockTransactionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $csvdate = Carbon::parse($row['transaction_date'])->format('Y-m-d');
        $code = $row['code'];
        $ins_row = Instrument::where('instrument_code',$code)->first();
        $ins_id = '';
        if($ins_row) {
            $ins_id = $ins_row->id;
        }
        else {
            $ins_add = Instrument::create(
                [
                    'exchange_id'=>1,
                    'sector_list_id'=>0,
                    'instrument_code'=>$row['code'],
                    'name'=>$row['code']
                ]
            );
            $ins_id = $ins_add->id;
        }
        $isExisted = BlockTransaction::where(
            [
                ['instrument_id', '=', $ins_id],
                ['transaction_date', '=', $csvdate]
            ]
        )->first();

        if($row['transaction_date'] && $csvdate != '1970-01-01' && $ins_id && !$isExisted) {
            return new ImportBlockTransaction([
                'instrument_id'=>$ins_id,
                'quantity'=>$row['quantity'],
                'value'=>$row['value'],
                'trades'=>$row['trades'],
                'max_price'=>$row['max_price'],
                'min_price'=>$row['min_price'],
                'transaction_date'=>$csvdate,
            ]);
        }
        
    }
}
