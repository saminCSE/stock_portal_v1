<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRoleRequest extends FormRequest
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
            'role_id' => [
                'required',
                Rule::unique('role_menus')->ignore($this->rolemenu->id ?? 0),
            ],
            
        ];
    }

    public function messages(){
        return [
            'role_id.required' => 'The role field is required.',
            'role_id.unique' => 'The role has already been taken.',
        ];
       
    }
}
