<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OfficeRequest extends FormRequest
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
                'required','max:150',
                Rule::unique('offices')->ignore($this->office->id ?? 0),
            ],
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|min:11|max:15'
        ];
    }
}
