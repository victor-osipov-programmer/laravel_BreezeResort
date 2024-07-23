<?php

namespace App\Exceptions;

use Exception;

class Unauthorized extends GeneralError
{
    public array $errors;
    public function __construct($message = 'Unauthorized', array $errors = [])
    {
        parent::__construct($message, 401);
        $this->errors = $errors;
    }
}
