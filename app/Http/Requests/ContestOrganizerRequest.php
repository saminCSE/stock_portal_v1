<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ContestOrganizerRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $requestMethod = $request->method();
        return [
            'contest_id' => [
                'required',
            ],
            'name' => [
                'required',
                'regex:/^[A-Za-z][A-Za-z0-9\s]*$/',
                'max:255',
            ],
            'email' => [
                'required',
                'email'
            ],
            'phone' => [
                'required',
                'numeric',
                'digits:11'
            ],
            'is_active' => [
                'required',
            ],
        ];
    }
    public function messages(){
        return [
            'name.required'            => 'The name field is required!',
            'name.regex'               => 'Please input valid name!',
            'is_active.required'        => 'The active status field is required!',
        ];
    }
}
