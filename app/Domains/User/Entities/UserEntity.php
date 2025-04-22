<?php 
namespace App\Domains\User\Entities;

class UserEntity
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $name,
    ) {}
}
