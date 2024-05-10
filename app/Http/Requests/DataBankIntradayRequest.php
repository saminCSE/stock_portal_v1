<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DataBankIntradayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'market_id' => [
                'required',
            ],
            'instrument_id' => [
                'required',
            ],
            'quote_bases' => [
                'required',
            ],
            'open_price' => [
                'required',
            ],
            'pub_last_traded_price' => [
                'required',
            ],
            'spot_last_traded_price' => [
                'required',
            ],
            'high_price' => [
                'required',
            ],
            'low_price' => [
                'required',
            ],
            'close_price' => [
                'required',
            ],
            'yday_close_price' => [
                'required',
            ],
            'total_trades' => [
                'required',
            ],
            'total_volume' => [
                'required',
            ],
            'new_volume' => [
                'required',
            ],
            'total_value' => [
                'required',
            ],
            'public_total_trades' => [
                'required',
            ],
            'public_total_volume' => [
                'required',
            ],
            'public_total_value' => [
                'required',
            ],
            'spot_total_trades' => [
                'required',
            ],
            'spot_total_volume' => [
                'required',
            ],
            'spot_total_value' => [
                'required',
            ],
            'lm_date_time' => [
                'required',
            ],
            'trade_time' => [
                'required',
            ],
            'trade_date' => [
                'required',
            ],
            'batch' => [
                'required',
            ],
        ];
    }
}
