<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CommissionRequest extends FormRequest
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
    public function rules(Request $request 	)
    {
        $requestMethod = $request->method();
        return [
            'title' => [
                'required',
            ], 
            'value' => [
                'required',
                'numeric',
            ],    
            'is_active' => [
                'required',
            ],
        ];
    }
    public function messages(){
        return [
            'title.required'          => 'The commission Title field is required!',
            'value.required'          => 'The value field is required!',
            'value.numeric'           => 'The value field is must be numeric number!',
            'is_active.required'      => 'The Active status field is required!',
        ];
    }
}
