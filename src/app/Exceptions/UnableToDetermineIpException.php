<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class UnableToDetermineIpException extends Exception
{
    public function __construct(
        string $message = 'Unable to determine user IP.',
        int $code = 403,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
