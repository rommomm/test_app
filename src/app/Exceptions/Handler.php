<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof CredentialInvalidException) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        }

        if ($e instanceof UnavailableServiceException) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 503);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json([
                'message' => 'Access Denied',
            ], 403);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        if ($e instanceof UnableToDetermineIpException) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 403);
        }

        if ($e instanceof AccessDeniedIpException) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 403);
        }

        return parent::render($request, $e);
    }
}
