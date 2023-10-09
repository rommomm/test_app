<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

abstract class BasePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, $model): bool
    {
        return $this->checkUserMatch($user, $model);
    }

    public function delete(User $user, $model): bool
    {
        return $this->checkUserMatch($user, $model);
    }

    protected function checkUserMatch(User $user, $model): bool
    {
        return $user->id === $model->user_id;
    }
}
