<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyInterimFinancialRequest extends FormRequest
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
                Rule::unique('company_interim_financial_performance')->ignore($this->company_interim->id ?? 0),
            ],
            'turnover' => [
                'required',
            ],
            'pfco' => [
                'required',
            ],
            'pftp' => [
                'required',
            ],
            'tcip' => [
                'required',
            ],
            'basic_eps' => [
                'required',
            ],
            'diluted_eps' => [
                'required',
            ],
            'basic_epsco' => [
                'required',
            ],
            'diluted_epsco' => [
                'required',
            ],
            'mppspe' => [
                'required',
            ],
            'q1' => [
                'required',
            ],
            'q2' => [
                'required',
            ],
            'half_yearly' => [
                'required',
            ],
            'q3' => [
                'required',
            ],
            'nine_months' => [
                'required',
            ],
            'annual' => [
                'required',
            ],
        ];
    }
}
