<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PrizeRequest extends FormRequest
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
            'rank' => [
                'required',
            ],
            'award' => [
                'required',
            ],
            'remark' => [
                'required',
            ],
            'is_active' => [
                'required',
            ],
        ];
    }
    public function messages(){
        return [
            'is_active.required'        => 'The active status field is required!',
        ];
    }
}
