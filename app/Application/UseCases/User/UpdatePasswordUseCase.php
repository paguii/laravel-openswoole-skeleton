<?php

namespace App\Application\UseCases\User;

use App\Application\Services\User\UserService;
use App\Domain\Entities\User;

class UpdatePasswordUseCase
{
    private UserService $userService;

    /**
     * Constructor for UpdatePasswordUseCase.
     * 
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Executes the update password use case.
     *
     * @param string $userId
     * @param array $data
     * 
     * @return User
     */
    public function execute(string $userId, array $data): User
    {
        return $this->userService->updateUserPassword($userId, $data);
    }
}
