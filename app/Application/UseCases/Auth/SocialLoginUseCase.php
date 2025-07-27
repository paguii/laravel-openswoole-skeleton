<?php

namespace App\Application\UseCases\Auth;

use App\Application\Services\Auth\AuthService;
use App\Application\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User;

class SocialLoginUseCase
{

    private AuthService $authService;
    private UserService $userService;

    /**
     * Constructor for SocialLoginUseCase.
     * 
     * @param AuthService $authService
     * @param UserService $userService
     */
    public function __construct(AuthService $authService, UserService $userService) 
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * Executes the social login use case.
     *
     * @param User $user
     * @param string $provider
     * 
     * @return void
     */
    public function execute(User $user, string $provider): void
    {
        $registeredUser = $this->userService->getUserByEmail($user->getEmail());

        if ($registeredUser === null) {
            $registeredUser = $this->userService->createUserFromSocialLogin($user, $provider);
        }

        $this->authService->authenticateSocialLoginUser($registeredUser);
    }
}