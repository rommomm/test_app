<?php

namespace App\DTO;

class UserDTO
{
    public $name;
    public $email;
    public $password;
    public $provider_id;
    public $provider;
    public $provider_token;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->provider_id = $data['provider_id'] ?? null;
        $this->provider = $data['provider'] ?? null;
        $this->provider_token = $data['provider_token'] ?? null;
    }

    public function signInCredentials(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'provider_id' => $this->provider_id,
            'provider' => $this->provider,
            'provider_token' => $this->provider_token,
        ], fn($value) => $value !== null);
    }
}
