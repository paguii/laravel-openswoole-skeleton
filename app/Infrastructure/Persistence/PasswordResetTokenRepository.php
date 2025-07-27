<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\PasswordResetToken;
use App\Domain\Entities\User;
use App\Domain\Repositories\PasswordResetTokenRepositoryInterface;

class PasswordResetTokenRepository implements PasswordResetTokenRepositoryInterface
{
    /**
     * Finds a password reset token by email.
     * 
     * @param string $email
     * 
     * @return PasswordResetToken|null
     */
    public function findByEmail(string $email): ?PasswordResetToken
    {
        return PasswordResetToken::where('email', $email)->first();
    }

    /**
     * Finds a password reset token by token.
     * 
     * @param string $token
     * 
     * @return PasswordResetToken|null
     */
    public function findByToken(string $token): ?PasswordResetToken
    {
        return PasswordResetToken::where('token', $token)->first();
    }

    /**
     * Creates a new password reset token.
     * 
     * @param array $data
     * 
     * @return PasswordResetToken
     */
    public function create(array $data): PasswordResetToken
    {
        return PasswordResetToken::create($data);
    }

    /**
     * Deletes a password reset token by email.
     * 
     * @param string $email
     * 
     * @return bool
     */
    public function delete(string $email): bool
    {
        return PasswordResetToken::destroy($email);
    }
}
