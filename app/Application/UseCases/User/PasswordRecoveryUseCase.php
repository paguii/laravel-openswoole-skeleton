<?php

namespace App\Application\UseCases\User;

use App\Application\Services\User\UserService;

class PasswordRecoveryUseCase
{
    private UserService $userService;

    /**
     * Constructor for PasswordRecoveryUseCase.
     * 
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Executes the password recovery use case.
     *
     * @param string $token
     * @param string $password
     * @param string $passwordConfirmation
     * 
     * @return void
     */
    public function execute(string $token, string $password, string $passwordConfirmation): void
    {
        $this->userService->passwordRecovery($token, $password, $passwordConfirmation);
    }
}
