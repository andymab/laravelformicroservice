<?php

namespace App\Application\User\Services;

use App\Domains\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Str;


class LoginService
{
    public function __construct(protected UserRepositoryInterface $users) {}

    public function attempt(string $email, string $password): ?array
    {
        if (! $this->users->validateCredentials($email, $password)) {
            return null;
        }

        $user = \App\Models\User::where('email', $email)->first();

        // Удалим старые токены (опционально)
        $user->tokens()->delete();

        // Создаем access token
        $accessToken = $user->createToken('access_token')->plainTextToken;

        // Генерируем refresh token
        $refreshToken = Str::random(60);

        // Сохраняем refresh token
        $user->refresh_token = $refreshToken;
        $user->save();

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'user' => $user->only(['id', 'email', 'name']),
        ];
    }

    public function refreshToken(string $refreshToken): ?array
    {
        $user = \App\Models\User::where('refresh_token', $refreshToken)->first();

        if (! $user) {
            return null;
        }

        $user->tokens()->delete();
        $newAccessToken = $user->createToken('access_token')->plainTextToken;
        $newRefreshToken = Str::random(60);

        $user->refresh_token = $newRefreshToken;
        $user->save();

        return [
            'access_token' => $newAccessToken,
            'refresh_token' => $newRefreshToken,
        ];
    }
}
