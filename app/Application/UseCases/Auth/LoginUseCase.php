<?php

namespace App\Application\UseCases\Auth;

use App\Application\Services\Auth\AuthService;

class LoginUseCase
{
    private AuthService $authService;

    /**
     * Constructor for LoginUseCase.
     * 
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Executes the login use case.
     *
     * @param string $username
     * @param string $password
     * @param bool $remember
     * 
     * @return void
     */
    public function execute(string $username, string $password, bool $remember): void
    {
        $this->authService->authenticateUser($username, $password, $remember);
    }
}