<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueDateForExchange implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $exchangeName;

    public function __construct($exchangeName)
    {
        $this->exchangeName = $exchangeName;
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
        $count = DB::table('holiday_management')
            ->where('date', $value)
            ->where('exchange_name', $this->exchangeName)
            ->count();

        return $count === 0;
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A holiday with the same date and exchange name already exists.';
    }
}
