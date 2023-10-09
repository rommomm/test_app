<?php

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Exceptions\CredentialInvalidException;
use Laravel\Socialite\Facades\Socialite;

class AuthRepository
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function signUp(UserDTO $userDTO): string
    {
        $user = $this->userRepository->create($userDTO);

        return $user->createToken($userDTO->email)->plainTextToken;
    }

    /**
     * @throws CredentialInvalidException
     */
    public function signIn(UserDTO $userDTO): string
    {
        if (!auth()->attempt($userDTO->signInCredentials())) {
            throw new CredentialInvalidException();
        }

        return $this->userRepository->getUserByEmail($userDTO->email)->createToken($userDTO->email)->plainTextToken;
    }

    public function signOut(): void
    {
        session()->flush();
        auth('web')->logout();
        auth()->user()?->currentAccessToken()->delete();
    }

    public function callback($provider): void
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = $this->userRepository->updateOrCreate(
            ['email' => $socialUser->email],
            new UserDTO([
                'provider_id' => $socialUser->id,
                'provider' => $provider,
                'name' => $socialUser->name,
                'provider_token' => $socialUser->token
            ]));

        auth()->login($user);
    }
}
