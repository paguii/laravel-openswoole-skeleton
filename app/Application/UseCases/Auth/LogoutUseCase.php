<?php

namespace App\Application\UseCases\Auth;

use App\Application\Services\Auth\AuthService;

class LogoutUseCase
{
    public function __construct()
    {

    }

    /**
     * Executes the logout use case.
     *
     * @return void
     */
    public function execute(): void
    {
        AuthService::destroy();
    }
}