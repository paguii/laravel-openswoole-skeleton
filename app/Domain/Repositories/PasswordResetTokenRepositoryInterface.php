<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\PasswordResetToken;

interface PasswordResetTokenRepositoryInterface
{
    public function findByEmail(string $email): ?PasswordResetToken;
    public function findByToken(string $token): ?PasswordResetToken;
    public function create(array $data): PasswordResetToken;
    public function delete(string $email): bool;
}
