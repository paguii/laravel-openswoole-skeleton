<?php

namespace App\Application\UseCases\User;

use App\Application\Services\User\UserService;

class RegisterUseCase
{
    private UserService $userService;

    /**
     * Constructor for RegisterUseCase.
     * 
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Executes the user registration use case.
     *
     * @param array $data
     * 
     * @return void
     */
    public function execute(array $data): void
    {
        $this->userService->createUser($data);
    }
}
