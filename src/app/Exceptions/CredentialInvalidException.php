<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class CredentialInvalidException extends Exception
{
    public function __construct(
        string $message = 'Credentials are invalid, please check your email or password',
        int $code = 401,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
