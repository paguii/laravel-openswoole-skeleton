<?php

namespace App\Application\UseCases\User;

use App\Application\Services\User\UserService;

class ForgotPasswordUseCase
{

    private UserService $userService;

    /**
     * Constructor for ForgotPasswordUseCase.
     * 
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Executes the forgot password use case.
     *
     * @param string $email
     * 
     * @return void
     */
    public function execute(string $email): void
    {
        $this->userService->sendPasswordResetLink($email);
    }
}
