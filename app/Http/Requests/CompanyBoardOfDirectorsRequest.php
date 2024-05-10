<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyBoardOfDirectorsRequest extends FormRequest
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
            'company_id' => [
                'required',
            ],
            'directors_profiles_id' => [
                'required',
            ],
            'designation_id' => [
                'required',
            ],
            'share_percentage' => [
                'required','numeric',
            ],
            'start_date' => [
                'required',
            ],
            'end_date' => [
                'required',
            ],
//            'email' => [
//                'email:rfc,dns'
//            ],
//            'phone' => [
//                'digits:11',
//                'numeric',
//            ],
        ];
    }
    public function messages(){
        return [
            'company_id.required'             => 'The company name field is required.',
            'directors_profiles_id.required'  => 'The director name field is required.',
            'designation_id.required'         => 'The designation field is required.',
            'share_percentage.required'       => 'The director share field percentage is required.',
            'share_percentage.numeric'        => 'The director share field is must be numeric.',
            'start_date.required'             => 'The start date field is required.',
            'end_date.required'               => 'The end date field is required.',

        ];
    }
}
