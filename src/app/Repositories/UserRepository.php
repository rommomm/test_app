<?php

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Models\User;

class UserRepository
{
    public function __construct()
    {
    }

    /**
     * @param UserDTO $userDTO
     * @return User
     */
    public function create(UserDTO $userDTO): User
    {
        return User::create($userDTO->toArray());
    }

    /**
     * @param array $attributes
     * @param UserDTO $userDTO
     * @return User
     */
    public function updateOrCreate(array $attributes, UserDTO $userDTO): User
    {
        return User::updateOrCreate($attributes, $userDTO->toArray());
    }

    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }
}
