<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    public function __construct($message, $code = 404)
    {
        parent::__construct($message, $code);
    }
}