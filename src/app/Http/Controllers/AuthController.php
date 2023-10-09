<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Exceptions\CredentialInvalidException;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;

class AuthController
{
    public function __construct(
        private AuthRepository $authRepository,
    ) {
    }

    public function signUp(SignUpRequest $request): JsonResponse
    {
        $user = new UserDTO($request->validated());

        return response()->json($this->authRepository->signUp($user));
    }

    /**
     * @throws CredentialInvalidException
     */
    public function signIn(SignInRequest $request): JsonResponse
    {
        $user = new UserDTO($request->validated());

        return response()->json($this->authRepository->signIn($user));
    }

    public function signOut(): JsonResponse
    {
        $this->authRepository->signOut();

        return response()->json();
    }
}
