<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlockTransactionRequest extends FormRequest
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
            'instrument_id' => [
                'required','unique:block_transactions,transaction_date',
            ],
            'quantity' => [
                'required','numeric'
            ],
            'value' => [
                'required','regex:/^\d+(\.\d{1,5})?$/',
            ],
            'trades' => [
                'required','numeric'
            ],
            'max_price' => [
                'required','regex:/^\d+(\.\d{1,5})?$/'
            ],
            'min_price' => [
                'required','regex:/^\d+(\.\d{1,5})?$/'
            ],
            'transaction_date' => [
                'required'
            ],
        ];
    }
    public function messages(){
        return [
            'instrument_id.required'    => 'The Block Transaction field is required.',
            'instrument_id.unique'      => 'This symbol data is already input on this date!.',
            'instrument_id.numeric'     => 'Please enter only numeric values in this field ',
            'quantity.required'         => 'The block transaction field is required.',
            'quantity.numeric'          => 'Please enter only numeric values in this field. ',
            'value.required'            => 'The block transaction field is required.',
            'trades.required'           => 'The block transaction field is required.',
            'trades.numeric'            => 'Please enter only numeric values in this field. ',
            'max_price.required'        => 'The block transaction field is required.',
            'min_price.required'        => 'The block transaction field is required.',
            'transaction_date.required' => 'The block transaction field is required.',
        ];
    }
}
