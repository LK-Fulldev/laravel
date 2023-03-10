<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MultipleValidEmails implements Rule
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
        if (!is_array($value)) {
            return false;
        }

        $validEmailCount = 0;
        foreach ($value as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $validEmailCount++;
            }
        }

        return $validEmailCount >= 2;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
