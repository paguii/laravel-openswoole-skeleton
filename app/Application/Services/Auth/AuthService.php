<?php

namespace App\Application\Services\Auth;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Exceptions\AuthenticationException;
use App\Exceptions\RateLimitException;
use App\Infrastructure\Persistence\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public static function build(): AuthService
    {
        return new self(new UserRepository());
    }

    public function authenticateUser(string $email, string $password, bool $remember)
    {
        $throttleKey = self::throttleKey($email);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw new AuthenticationException('Muitas tentativas de login. Tente novamente mais tarde.');
        }

        if (!Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            RateLimiter::hit($throttleKey);
            throw new AuthenticationException('Credenciais Inválidas');
        }

        RateLimiter::clear($throttleKey);
    }

    public function authenticateSocialLoginUser(User $user)
    {
        Auth::login($user);
    }

    public static function isRateLimitReached(string $key, int $attempts): void
    {
        if (!RateLimiter::tooManyAttempts($key, $attempts)) {
            return;
        }

        throw new RateLimitException('Falha ao autenticar. Excedeu o número de tentativas: ' . $attempts);
    }

    public static function throttleKey(string $word): string
    {
        return Str::transliterate(Str::lower($word));
    }

    public static function isAuthenticated(): bool
    {
        return Auth::check();
    }

    public static function destroy()
    {
        Auth::logout();
    }
}
