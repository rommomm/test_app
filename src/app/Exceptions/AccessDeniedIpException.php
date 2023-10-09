<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class AccessDeniedIpException extends Exception
{
    public function __construct(
        string $message = 'Access denied. User IP is not from Ukraine.',
        int $code = 403,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
