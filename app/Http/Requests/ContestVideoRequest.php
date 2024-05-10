<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ContestVideoRequest extends FormRequest
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
            'contests_id' => [
                'required',
                Rule::unique('contest_videos')->where(function ($query) use ($requestMethod) {
                    if($requestMethod == 'PUT') {
                        return $query->where('contests_id', $this->contests_id)->where('contests_id','!=',$this->contests_id);
                    }
                    else {
                        return $query->where('contests_id', $this->contests_id);
                    }
                }),
            ],

            'is_active' => [
                'required',
            ],
        ];
    }
    public function messages(){
        return [
            'is_active.required'        => 'The active status field is required!',
            'contests_id.unique'         => 'Video already store in our system please edit now!',
        ];
    }
}
