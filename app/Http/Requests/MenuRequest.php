<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
            'menu_name' => [
                'required',
                // Rule::unique('menus')->ignore($this->menu->id ?? 0),
            ],
            'slug' => [
                'nullable','required'
                // Rule::unique('menus')->ignore($this->menu->id ?? 0),
            ],
        ];
    }

    public function messages(){
        return [
            'menu_name.required' => 'The menu field is required.',
            'slug.required' => 'The menu field is required.',
        ];

    }
}
