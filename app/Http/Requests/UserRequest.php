<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'username' => [
                'required','max:150',
                Rule::unique('users')->ignore($this->user->id ?? 0),
            ],
            'email' => [
                'required','max:150',
                Rule::unique('users')->ignore($this->user->id ?? 0),
            ],
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'office_id'=>'required',
        ];
    }
}
