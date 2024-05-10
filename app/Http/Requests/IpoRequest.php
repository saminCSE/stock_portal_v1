<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IpoRequest extends FormRequest
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
            'name' => [
                'required','unique:ipo',
            ],
            'board' => [
                'required',
            ],
          
            'asset_class' => [
                'required',
            ],
          
            'methods' => [
                'required','max:500'
            ],
          
            'status' => [
                'required',
            ],
          
            'Open_date' => [
                'required',
            ],
            'close_date'=>[
                'required',
            ],
            'ipo_size'=>[
                'required',
            ],
            'offer_price'=>[
                'required',
            ],
            'summary'=>[
               'mimes:pdf,docx,xlsx'
            ],
            'prospectors'=>[
                'mimes:pdf,docx,xlsx'
            ],
            'results'=>[
                'mimes:pdf,docx,xlsx'
            ],
        ];
    }
    public function messages(){
        return [
            'name.required' => 'The ipo name is required.',
            'board.required' => 'The board is required.',
            'asset_class.required' => 'Please select asset class.',
            'methods.required' => 'Methods is required.',
            'status.required' => 'Ipo status is required.',
            'Open_date.required' => 'Open date is required.',
            'close_date.required' => 'Close date is required.',
            'ipo_size.required' => 'Ipo size is required.',
            'offer_price.required' => 'Offer price is required.',
        ];
       
    }
}
