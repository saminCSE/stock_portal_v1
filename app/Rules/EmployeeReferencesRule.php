<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmployeeReferencesRule implements Rule
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
        $attribute_index = explode('.',$attribute);
        $name = request()->emp_ref_name[$attribute_index[1]];
        $relation = request()->relation[$attribute_index[1]];
        $present_address = request()->emp_ref_present_address[$attribute_index[1]];
        $permanent_address = request()->emp_ref_permanent_address[$attribute_index[1]];
        if(($name == true || $relation == true || $present_address == true || $permanent_address) && !$value ){

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
