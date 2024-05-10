<?php

namespace App\Imports;

use App\Models\DataBanksEod;
use App\Models\DataBanksIntraday;
use App\Models\ImportUser;
use App\Models\Instrument;
use App\Models\Market;
use Illuminate\Bus\Batch;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EodImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       
       
        $csvdate = Carbon::parse($row['date'])->format('Y-m-d');
        $code = $row['ticker'];
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
                    'instrument_code'=>$row['ticker'],
                    'name'=>$row['ticker']
                ]
            );
            $ins_id = $ins_add->id;
        }

        $marketExisted = Market::select('id','data_bank_intraday_batch','trade_date')->where(
            [
                ['trade_date', '=', $csvdate]
            ]
        )->first();

        if(!$marketExisted) {

            $max_market = Market::max('data_bank_intraday_batch');
           
            
            if ($max_market) {
               $batchNumber = $max_market + 1;
            }
            else {
                $batchNumber = 1;
            }

            $market_data = [
                'trade_date'=>$csvdate,
                'market_started'=>'10:00:00',
                'market_closed'=>"02:20:00",
                'exchange_id'=>1,
                'data_bank_intraday_batch'=>$batchNumber,
                'batch_total_trades'=>"",
            ];
            $market_data = Market::create($market_data);
            $market_id = $market_data->id;
            
        }
        else {
            $batchNumber = $marketExisted->data_bank_intraday_batch;
            $market_id = $marketExisted->id;
            
        }
      
        $isExisted = DataBanksEod::where(
            [
                ['instrument_id', '=', $ins_id],
                ['date', '=', $csvdate]
            ]
        )->first();
        
        

        if($row['date'] && $csvdate != '1970-01-01' && $ins_id && !$isExisted) {

            // echo ' if <br>';
            // echo $row['date'].'\n <br>';
            // echo $csvdate.'\n <br>';
            // echo $ins_id.'\n <br>';
            // echo $isExisted.'\n <br>';
            // dd($isExisted);
            // exit;
            
            return new ImportUser([
                'market_id'=>$market_id,
                'instrument_id'=>$ins_id,
                'date'=>$csvdate,
                'open'=>$row['open'],
                'high'=>$row['high'],
                'low'=>$row['low'],
                'close'=>$row['close'],
                'volume'=>$row['volume'],
                'batch'=>$batchNumber,
            ]);
             
        }
        else if($isExisted) {
            $dataUpdate = [
                'open'=>$row['open'],
                'high'=>$row['high'],
                'low'=>$row['low'],
                'close'=>$row['close'],
                'volume'=>$row['volume']
            ];
            
             DataBanksEod::where('id',$isExisted->id)->update($dataUpdate);
        }
      
    }
}
