<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyAgmRequest extends FormRequest
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
            'last_agm_held_on' => [
                'required',
            ],
            'right_issue' => [
                'required',
            ],
            'year_end' => [
                'required',
            ],
            'reserve_surplus' => [
                'required',
            ],
            'comprehensive_income' => [
                'required',
            ],
        ];
    }
}
