<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContestOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function productorderprocess($data)
    {

        // dd($data);
        $product = self::create($data);

        if ($product) {


            $bo_account_portfolio = self::bo_account_portfolio($data);

            $profile_data = ContestProfile::where('portal_user_id', $product->portal_user_id)->where('contests_id', $product->contests_id)->first();

            if ($profile_data) {
                $balance = $data['side'] == 'B' ? $profile_data->balance - ($data['value'] + $data['total_commision']) : ($profile_data->balance + $data['value']) - $data['total_commision'];
                $profile_data->balance = $balance;
                $profile_data->save();
            } else {

                $balance = $data['side'] == 'B' ? -($data['value'] + $data['total_commision']) : $data['value'] - $data['total_commision'];

                $account_holder = array(
                    'contests_id' => $data['contests_id'],
                    'portal_user_id' => $data['portal_user_id'],
                    // 'commission'=>$data['total_commision'],
                    'balance' => $balance,
                );
                ContestProfile::create($account_holder);
            }

            $account_ledger = array(
                'contests_id' => $data['contests_id'],
                'portal_user_id' => $data['portal_user_id'],
                'instrument_code' => $data['instrument_code'],
                'remark' => $data['side'] == 'B' ? $data['instrument_code'] . ' ' . 'buy' : $data['instrument_code'] . ' ' . 'sale',
                'quantity' => $data['quantity'],
                'price' => $data['price'],
                'credit' => $data['side'] == 'S' ? $data['value'] : 0,
                'debit' => $data['side'] == 'B' ? $data['value'] : 0,
                'commission' => $data['total_commision'],
                'balance' => $balance,
                'purchase_date' => $data['purchase_date'],
                'purchase_time' => $data['purchase_time']
            );

            $profile_ledger = ContestLedger::create($account_ledger);
        }
    }
    private static function bo_account_portfolio($data)
    {

        $bo_instrument = ContestPortfolio::where(['portal_user_id' => $data['portal_user_id'], 'contests_id' => $data['contests_id'], 'instrument_code' => $data['instrument_code']])->first();

        $total_value = $data['value'] + $data['total_commision'];

        if ($bo_instrument) {
            if ($data['side'] == 'B') {
                $bo_instrument->total_buy = $bo_instrument->total_buy + $data['quantity'];
                $bo_instrument->total_cost_value = $bo_instrument->total_cost_value + $total_value;
                $bo_instrument->current_cost_value = $bo_instrument->current_cost_value + $total_value;
                $bo_instrument->current_avg_cost = round($bo_instrument->current_cost_value / ($bo_instrument->pending_holding_quantity + $bo_instrument->saleable_quantity + $data['quantity']), 4);
                $bo_instrument->pending_holding_quantity = $bo_instrument->pending_holding_quantity + $data['quantity'];
                $bo_instrument->market_price = DB::table('company_basic_information')->where('code', $data['instrument_code'])->first()->market_price;
            } else {
                $bo_instrument->total_sale = $bo_instrument->total_sale + $data['quantity'];
                $bo_instrument->saleable_quantity = $bo_instrument->saleable_quantity > 0 ? $bo_instrument->saleable_quantity - $data['quantity'] : 0;
                $bo_instrument->current_cost_value = $bo_instrument->current_cost_value > 0 ? $bo_instrument->current_cost_value - $data['value'] : 0;
                $bo_instrument->total_sale_value = $bo_instrument->total_sale_value + $data['value'] - $data['total_commision'];

                // if ($bo_instrument->total_cost_value > $bo_instrument->total_sale_value) {
                //     $bo_instrument->total_loss = $bo_instrument->total_cost_value - $bo_instrument->total_sale_value;
                // } else {
                //     $bo_instrument->total_gain = $bo_instrument->total_sale_value - $bo_instrument->total_cost_value;
                // }
                $neat_gain = ($bo_instrument->total_gain - $bo_instrument->total_loss) + $bo_instrument->total_sale_value - $bo_instrument->total_cost_value + (($bo_instrument->saleable_quantity + $bo_instrument->pending_holding_quantity) * $bo_instrument->current_avg_cost);
                if ($neat_gain > 0) {
                    $bo_instrument->total_gain = $neat_gain;
                    $bo_instrument->total_loss = 0;
                } else {
                    $bo_instrument->total_loss = -1 * $neat_gain;
                    $bo_instrument->total_gain = 0;
                }
            }
            return $bo_instrument->save();
        } else {

            $total_cost = $data['side'] == 'B' ? $data['value'] + $data['total_commision'] : 0;
            $bo_profile_added = array(
                'contests_id' => $data['contests_id'],
                'portal_user_id' => $data['portal_user_id'],
                'instrument_code' => $data['instrument_code'],
                'total_buy' => $data['side'] == 'B' ? $data['quantity'] : 0,
                'total_sale' => $data['side'] == 'B' ? 0 : $data['quantity'],
                'saleable_quantity' => 0,
                'pending_holding_quantity' => $data['side'] == 'B' ? $data['quantity'] : 0,
                'market_price' => DB::table('company_basic_information')->where('code', $data['instrument_code'])->first()->market_price,
                'total_cost_value' => $data['side'] == 'B' ? $data['value'] + $data['total_commision'] : 0,
                'total_sale_value' => $data['side'] == 'B' ? 0 : $data['value'] - $data['total_commision'],
                'current_cost_value' => $data['side'] == 'B' ? $total_cost : 0,
                'current_avg_cost' => $data['side'] == 'B' ? round($total_cost / $data['quantity'], 4) : 0
            );

            return ContestPortfolio::create($bo_profile_added);
        }
    }

    private static function diffTwoDate($preDate)
    {

        $today = date('Y-m-d');

        $difference = strtotime($today) - strtotime($preDate);

        //Calculate difference in days
        $days = abs($difference / (60 * 60) / 24);

        return $days;
    }

    public static function changeUnMeasuredRecord($data)
    {

        // DB::enableQueryLog();
        $board = DB::table('exchanges as a')
            ->select('a.id', 'a.title', 'c.title as board_cateogry_title', 'c.schedule_day')
            ->leftJoin('exchange_bords as b', 'a.id', '=', 'b.exchanges_id')
            ->leftJoin('market_categories as c', 'b.id', '=', 'c.exchange_bord_id')
            ->where(['a.title' => 'DSE', 'b.title' => $data['board'], 'c.title' => $data['category']])
            ->first();
        //DD(DB::getQueryLog());
        $schedule_day = $board ? $board->schedule_day : 0;
        // $difference_day = self::diffTwoDate($data['purchase_date']);
        $difference_day = DB::table('markets')->where('trade_date', '>=', $data['purchase_date'])
            ->count();
        // dd($difference_day);
        $current_day = $schedule_day + 1;

        if ($difference_day >= $current_day) {

            $data_record = ContestPortfolio::where(['portal_user_id' => $data['portal_user_id'], 'instrument_code' => $data['instrument_code'], 'contests_id' => $data['contests_id']])->first();

            if ($data_record) {
                $data_record->pending_holding_quantity = $data_record->pending_holding_quantity - $data['quantity'];
                $data_record->saleable_quantity = $data_record->saleable_quantity + $data['quantity'];
                $data_record->save();
                ContestOrder::where('id', $data['id'])->update(['is_measure' => 1]);
            }
        }
    }
}
