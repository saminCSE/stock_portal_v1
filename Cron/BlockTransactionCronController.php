<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use GuzzleHttp\Client;
use Ixudra\Curl\Facades\Curl;
use App\Models\Instrument;
use App\Models\BlockTransaction;
use Illuminate\Support\Carbon;

class BlockTransactionCronController extends Controller
{
    public function addBlockTransactionByUrl()
    {
        // $response = Curl::to('https://www.dsebd.org/market-statistics.php')->get();
        //$response = file_get_contents('https://www.dsebd.org/market-statistics.php');

        $URL = 'https://www.dsebd.org/market-statistics.php';
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $response = curl_exec($c);
        curl_close($c);
    
       

    
        $pattern = '/([A-Z0-9]+)\s+([\d.]+)\s+([\d.]+)\s+(\d+)\s+(\d+)\s+([\d.]+)/';
    
        if (preg_match_all($pattern, $response, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $instrCode = $match[1];
                $maxPrice = $match[2];
                $minPrice = $match[3];
                $trades = $match[4];
                $quantity = $match[5];
                $value = $match[6];
    
                $instrument = Instrument::where('instrument_code', $instrCode)->first();
                $transaction_date = Carbon::parse()->format('Y-m-d');
                
                if (!$instrument) {
                    continue;
                }
                

                $existingRecord = blockTransaction::where('instrument_id', $instrument->id)
                    ->where('transaction_date', $transaction_date)
                    ->first();
    
                if ($existingRecord) {
                    continue; 
                }
    
                $formdata = [
                    'instrument_id' => $instrument->id,
                    'max_price' => $maxPrice,
                    'min_price' => $minPrice,
                    'trades' => $trades,
                    'quantity' => $quantity,
                    'value' => $value,
                    'transaction_date' => $transaction_date,
                ];
    
                $data = blockTransaction::create($formdata);
            }
                try {
                    $response = array(
                        'data' => $data,
                        'status' => 'Data inserted successfully',
                    );
                return response()->json($response);
            } catch (HttpException $e) {
                $response = array(
                    'data' => $e->getMessage(),
                    'status' => 'error',
                );
                return response()->json($response);
            }
        }
    }
    
}
