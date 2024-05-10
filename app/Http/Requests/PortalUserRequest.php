<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Models\PortalUser;

class PortalUserRequest extends FormRequest
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
        $userId = $this->route('portal_user') ? $this->route('portal_user')->id : null;
        return [
            'full_name' => [
                'required',
                'max:150',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('portal_user', 'email')->ignore($userId),
            ],
            'mobile' => [
                'required',
                'max:11',
                Rule::unique('portal_user', 'mobile')->ignore($userId),
            ],
            'password' => [
                'required_with:confirm_password',
                'min:6',
                'same:confirm_password',
            ],
            'confirm_password' => [
                'min:6',
            ],
            'agree_to_terms' => [
                'accepted',
            ],
        ];
    }    
}
