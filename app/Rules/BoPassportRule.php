<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BoPassportRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $passport_no = request()->passport_no;
        $passport_issue_place = request()->passport_issue_place;
        $passport_issue_date = request()->passport_issue_date;
        $passport_expiry_date = request()->passport_expiry_date;
        if(($passport_no == true || $passport_issue_place == true || $passport_issue_date == true || $passport_expiry_date) && !$value ){

           return false;
        }
        else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The field is required.';
    }
}
