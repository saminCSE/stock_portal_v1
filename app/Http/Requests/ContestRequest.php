<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ContestRequest extends FormRequest
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
            'title' => [
                'required',
                'max:255',
            ],
            'title_bn'                  => ['required',],
            'slug'                      => ['required',],
            'contest_type_id'           => ['required',],
            'short_description'         => ['required',],
            'short_description_bn'      => ['required',],
            'long_description'          => ['required',],
            'long_description_bn'       => ['required',],
            'amount'                    => ['required', 'integer'],
            'duration'                  => ['required',],
            'contest_start_date'        => ['required', 'date'],
            'contest_end_date'          => ['required', 'date'],
            'registration_start_date'   => ['required', 'date'],
            'registration_end_date'     => ['required', 'date'],
            'number_of_participation'   => ['required', 'integer'],
            'terms_and_conditions'      => ['required',],
            'terms_and_condition_bn'    => ['required',],
            'who_can_register'          => ['required',],
            'who_can_register_bn'       => ['required',],
            'contest_status_open'       => ['required',],
            'contest_status_open_bn'    => ['required',],
            'contest_status_close'      => ['required',],
            'contest_status_close_bn'   => ['required',],

            'is_active' => [
                'required',
            ],
        ];
    }
    public function messages()
    {
        return [
            'title.required'            => 'The title field is required!',
            'title.regex'               => 'Please input valid name!',
            'is_active.required'        => 'The active status field is required!',
        ];
    }
}
