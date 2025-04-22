<?php 
namespace App\Domains\User\Repositories;

use App\Domains\User\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?UserEntity;
    public function validateCredentials(string $email, string $password): bool;
}
