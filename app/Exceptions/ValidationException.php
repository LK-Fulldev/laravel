<?php

namespace App\Exceptions;

class ValidationException extends \Illuminate\Validation\ValidationException
{
    protected $stopOnFirstFailure = true;
}
