<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class CompanyBasicInfoRequest extends FormRequest
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
            'company_name' => [
                'required',
                Rule::unique('company_basic_information')->ignore($this->route('id') ?? 0),
            ],
            'code' => [
                'required',
            ],
            'xcode' => [
                'required',
            ],
            'company_description' => [
                'required',
            ],
            // 'incorporation_date' => [
            //     'required',
            // ],
            'scrip_code_dse' => [
                'required',
            ],
            'scrip_code_cse' => [
                'required',
            ],
            'listing_year_dse' => [
                'required',
            ],
            // 'listing_year_cse' => [
            //     'required',
            // ],
            'market_category' => [
                'required',
            ],
            'electronic_share' => [
                'required',
            ],
            'corporate_office_address' => [
                'required',
            ],
            'head_office_address' => [
                'required',
            ],
            'factory_office_address' => [
                'required',
            ],
            'fax' => [
                'required',
            ],
            'phone' => [
                'required',
            ],
        ];
    }
}
