<?php

namespace App\DTO;

use Illuminate\Contracts\Auth\Authenticatable;

class InvoiceDTO
{
    public int $amount;
    public string $description;
    private int $user_id;

    public function __construct(array $data, Authenticatable $user)
    {
        $this->amount = $data['amount'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->user_id = $user->id;
    }

    public function toArray(): array
    {
        return array_filter([
            'amount' => $this->amount,
            'description' => $this->description,
            'user_id' => $this->user_id,
        ], fn($value) => $value !== null);
    }
}
