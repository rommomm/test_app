<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class UnavailableServiceException extends Exception
{
    public function __construct(
        string $message = 'An error occurred while retrieving data',
        int $code = 503,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
