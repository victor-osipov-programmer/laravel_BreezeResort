<?php

namespace App\Exceptions;

use Exception;

class Unauthorized extends GeneralError
{
    public function __construct($message = 'Unauthorized') {
        parent::__construct($message, 401);
    }
}
