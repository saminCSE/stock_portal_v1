<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockTransaction;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use GuzzleHttp\Client;
use Ixudra\Curl\Facades\Curl;

class BlockTransactionsApiController extends Controller
{
    public function index(Request $request)
    {
        //$today = '2023-10-27';
        $pageLimit = 15;
        $today = $request->date;



        $record = BlockTransaction::select('id', 'transaction_date')->where('transaction_date', '=', $today)->count();

        if (!$record) {
            $markets = Market::select('id', 'trade_date')->where('trade_date', '<', $today)->orderBy('id', 'DESC')->first();
            $today = $markets->trade_date;
        }

        $collections = DB::table('block_transactions')
            ->leftJoin('instruments', 'block_transactions.instrument_id', '=', 'instruments.id')
            ->select('instruments.name as instruments_name', 'instruments.instrument_code as instruments_code', 'block_transactions.instrument_id as instrument_id', 'quantity', 'value', 'max_price', 'min_price')
            ->where('transaction_date', '=', $today)
            ->whereRaw("block_transactions.transaction_date = ? AND block_transactions.instrument_id = block_transactions.instrument_id", [$today])
            ->limit($pageLimit)
            ->get();
        $response = array(
            'data' => $collections,
            'rdate' => changeDateFormate($today, 'd-M-Y'),
            'status' => 'success',
        );
        return response()->json($response);
    }

    public function BlockTransactionList(Request $request)
    {
        
        try {
            //$today = '2023-10-26';
            $today = $request->date;
            $page = $request->page;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $record = BlockTransaction::select('id', 'transaction_date')->where('transaction_date', '=', $today)->count();

            if (!$record) {
                $markets = Market::select('id', 'trade_date')->where('trade_date', '<', $today)->orderBy('id', 'DESC')->first();
                $today = $markets->trade_date;
            }

          //  DB::enableQueryLog();
            $collections = DB::table('block_transactions')
                ->leftJoin('instruments', 'block_transactions.instrument_id', '=', 'instruments.id')
                ->select('instruments.name as instruments_name', 'instruments.instrument_code as instruments_code', 'block_transactions.instrument_id as instrument_id', 'quantity', 'value', 'max_price', 'min_price')
                ->where('transaction_date', '=', $today)
                ->whereRaw("block_transactions.transaction_date = ? AND block_transactions.instrument_id = block_transactions.instrument_id", [$today])
                ->offset($offset)
                ->limit($limit)
                ->get();
           // dd(DB::getQueryLog());
           

            $response = array(
                'data' => array(
                    'blocktransaction' => $collections
                ),
                'status' => 'success',
            );

            if($page == 1) {
                $instrumentnamelist = DB::table('instruments')
                ->select('instruments.name as instruments_name', 'instruments.id as instruments_id')
                ->get();

                $response['data']['instrumentnamelist'] = $instrumentnamelist;
            }
            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = array(
                'data' => $e->getMessage(),
                'status' => 'error',
            );
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function BlockTransactionSearchList(Request $request)
    {
        
        try {
            $today = $request->date;
            //$today = '2023-07-09';
            $symbol = $request->query('symbol');
            $page = $request->page;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $record = BlockTransaction::select('id', 'transaction_date')->where('transaction_date', '=', $today)->count();

            if (!$record) {
                $markets = Market::select('id', 'trade_date')->where('trade_date', '<', $today)->orderBy('id', 'DESC')->first();
                $today = $markets->trade_date;
            }

            $block_transaction = DB::table('block_transactions')
                ->leftJoin('instruments', 'block_transactions.instrument_id', '=', 'instruments.id')
                ->select('instruments.name as instruments_name', 'instruments.instrument_code as instruments_code', 'block_transactions.instrument_id as instrument_id', 'quantity', 'value', 'max_price', 'min_price')
                ->where('transaction_date', '=', $today)
                ->whereRaw("block_transactions.transaction_date = ? AND block_transactions.instrument_id = block_transactions.instrument_id", [$today])
                ->offset($offset)
                ->limit($limit);

            if (!empty($symbol)) {
                $block_transaction = $block_transaction->where('instruments.id', $symbol);
            }

            $block_transaction = $block_transaction->get();

            $response = array(
                'data' => $block_transaction,
                'status' => 'success',
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
