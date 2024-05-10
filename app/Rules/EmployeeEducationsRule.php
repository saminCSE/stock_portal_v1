<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

use Illuminate\Contracts\Validation\DataAwareRule;


class EmployeeEducationsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

   // protected $params = [];
    protected $data = [];
    public function __construct()
    {
      //  $this->params = $params;
    }

    // public function setData($data)
    // {
    //     $this->data = $data;
 
    //     return $this;
    // }
 

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
            $institute_name = request()->institute_name[$attribute_index[1]];
            $roll_no = request()->roll_no[$attribute_index[1]];
            $reg_no = request()->reg_no[$attribute_index[1]];
            $gpa = request()->gpa[$attribute_index[1]];
            $scale = request()->scale[$attribute_index[1]];
            if(($institute_name == true || $roll_no == true || $reg_no == true || $gpa == true || $scale == true ) && !$value ){

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
