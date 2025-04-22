<?php
namespace App\Infrastructure\Repositories;

use App\Models\User;
use App\Domains\User\Entities\UserEntity;
use App\Domains\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?UserEntity
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            return null;
        }

        return new UserEntity(
            id: $user->id,
            email: $user->email,
            name: $user->name,
        );
    }

    public function validateCredentials(string $email, string $password): bool
    {
        $user = User::where('email', $email)->first();

        return $user && Hash::check($password, $user->password);
    }
}
