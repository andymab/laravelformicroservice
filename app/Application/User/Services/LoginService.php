<?php

namespace App\Application\User\Services;

use App\Domains\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function __construct(protected UserRepositoryInterface $users) {}

    public function attempt(string $email, string $password): ?string
    {
        if (! $this->users->validateCredentials($email, $password)) {
            return null;
        }

        $user = \App\Models\User::where('email', $email)->first();

        return $user->createToken('access_token')->plainTextToken;
    }
}