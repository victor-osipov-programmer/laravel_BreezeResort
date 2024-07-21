<?php

namespace App\Exceptions;

use Exception;

class NotFound extends GeneralError
{
    public function __construct($message = 'Not found') {
        parent::__construct($message, 404);
    }
}
