<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyFinancialStatementRequest extends FormRequest
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
        $rules = [
            'instrument_id' => 'required',
            'date_time' => 'required|date',
            'quatar_text' => 'required',
            'is_active' => 'required',
            'file' => 'mimes:pdf'
        ];

        // Add file validation rule only for POST method
        if ($this->isMethod('post')) {
            $rules['file'] = 'required|mimes:pdf';
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'instrument_id.required' => 'Instrument Name is required.',
            'date_time.required' => 'Date is required.',
            'date_time.date' => 'Date must be a valid date format.',
            'quatar_text.required' => 'Quatar is required.',
            'file.required' => 'File is required.',
            'file.mimes' => 'File must be a PDF.',
            'is_active.required' => 'Status is required.',
        ];
    }
}
