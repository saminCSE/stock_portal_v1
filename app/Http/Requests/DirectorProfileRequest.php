<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DirectorProfileRequest extends FormRequest
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
                'required',
            ],
            'phone' => [
                'required',
                'digits:11',
                'numeric',
                Rule::unique('director_profiles')->ignore($this->director_profile->id ?? 0),
            ],
            'email' => [
                'required',
            ],
            'designation_id' => [
                'required',
            ],
            'description' => [
                'required',
            ],
        ];
    }
    public function messages(){
        return [
            'name.required'             => 'The director Name field is required!',
            'phone.required'            => 'The director phone field is required!',
            'phone.in:11'               => 'The director phone field is accept only 11 digit!',
            'phone.numeric'             => 'The director phone field is accept only numeric number',
            'phone.unique'              => 'This director phone number is already created!.',
            'email.required'            => 'The director email field is required!',
            'designation_id.required'   => 'The director designation field is required!',
            'description.required'      => 'The director description field is required!',
        ];
    }
}
