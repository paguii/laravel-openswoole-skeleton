<?php

namespace App\Application\UseCases\User;

use App\Application\Services\User\UserService;
use App\Domain\Entities\User;

class UpdateUseCase
{
    private UserService $userService;

    /**
     * Constructor for UpdateUseCase.
     * 
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Executes the update user use case.
     *
     * @param string $userId
     * @param array $data
     * 
     * @return User
     */
    public function execute(string $userId, array $data): User
    {
        return $this->userService->updateUser($userId, $data);
    }
}
