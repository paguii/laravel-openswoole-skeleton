<?php

namespace App\Presentation\Http\Controllers\Web;

use Exception;
use App\Presentation\Http\Response\ApiResponse;
use App\Exceptions\BusinessRuleException;
use App\Exceptions\InvalidParameterException;
use App\Utils\HttpStatus;
use App\Application\Services\User\UserService;
use App\Application\UseCases\User\PasswordRecoveryUseCase;
use App\Application\UseCases\User\ForgotPasswordUseCase;
use App\Application\UseCases\User\RegisterUseCase;
use App\Application\UseCases\User\UpdatePasswordUseCase;
use App\Application\UseCases\User\UpdateUseCase;
use App\Presentation\Http\Request\User\PasswordRecoveryRequest;
use App\Presentation\Http\Request\User\ForgotPasswordRequest;
use App\Presentation\Http\Request\User\RegisterUserRequest;
use App\Presentation\Http\Request\User\UpdateUserRequest;
use App\Presentation\Http\Request\User\UpdateUserPasswordRequest;
use App\Presentation\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function registerView(): View
    {
        return view('user.register');
    }

    public function profileView(): View
    {
        return view('user.profile');
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $response = new ApiResponse();

        try {
            $updateUseCase = new UpdateUseCase(UserService::build());
            $user = $updateUseCase->execute(Auth::user()->id, $request->all());

            $response->setSuccess(true);
            $response->setStatusCode(HttpStatus::OK);
            $response->setData($user->toArray());
        } catch (BusinessRuleException | InvalidParameterException $e) {
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::BAD_REQUEST);
            $response->setMessage($e->getMessage());
        } catch (Exception $e) {
            Log::error("Falha ao atualizar usuário: " . $e->getMessage());
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::INTERNAL_SERVER_ERROR);
            $response->setMessage('Erro Inesperado.');
        }

        return response()->json($response->toArray(), $response->getStatusCode());
    }

    public function updatePassword(UpdateUserPasswordRequest $request)
    {
        $response = new ApiResponse();

        try {
            $updatePasswordUseCase = new UpdatePasswordUseCase(UserService::build());
            $updatePasswordUseCase->execute(Auth::user()->id, $request->all());

            $response->setSuccess(true);
            $response->setStatusCode(HttpStatus::OK);
        } catch (BusinessRuleException | InvalidParameterException $e) {
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::BAD_REQUEST);
            $response->setMessage($e->getMessage());
        } catch (Exception $e) {
            Log::error("Falha ao atualizar senha: " . $e->getMessage());
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::INTERNAL_SERVER_ERROR);
            $response->setMessage('Erro Inesperado.');
        }

        return response()->json($response->toArray(), $response->getStatusCode());
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $response = new ApiResponse();

        $name = $request->input('name');
        $lastName = $request->input('last_name');
        $email = $request->input('email');
        $password = $request->input('password');
        $passwordConfirmation = $request->input('password_confirmation');

        try {
            $registerUseCase = new RegisterUseCase(UserService::build());
            $registerUseCase->execute([
                'name' => $name,
                'last_name' => $lastName,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $passwordConfirmation
            ]);

            $response->setSuccess(true);
            $response->setStatusCode(HttpStatus::CREATED);

        } catch (BusinessRuleException | InvalidParameterException $e) {
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::BAD_REQUEST);
            $response->setMessage($e->getMessage());
        } catch (Exception $e) {
            Log::error('Falha ao registrar usuário: ' . $e->getMessage());
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::INTERNAL_SERVER_ERROR);
            $response->setMessage('Erro Inesperado.');
        }

        return response()->json($response->toArray(), $response->getStatusCode());
    }

    public function passwordRecoveryView(): View
    {
        return view('user.password-recovery');
    }

    public function passwordRecovery(PasswordRecoveryRequest $request): JsonResponse
    {
        $response = new ApiResponse();

        $token = $request->input('token');
        $password = $request->input('password');
        $passwordConfirmation = $request->input('password_confirmation');

        try {
            $passwordRecoveryUseCase = new PasswordRecoveryUseCase(UserService::build());
            $passwordRecoveryUseCase->execute($token, $password, $passwordConfirmation);

            $response->setSuccess(true);
            $response->setStatusCode(HttpStatus::OK);

        } catch (BusinessRuleException | InvalidParameterException $e) {
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::BAD_REQUEST);
            $response->setMessage($e->getMessage());
        } catch (Exception $e) {
            Log::error("Falha ao recuperar senha do usuário: " . $e->getMessage());
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::INTERNAL_SERVER_ERROR);
            $response->setMessage('Erro Inesperado.');
        }

        return response()->json($response->toArray(), $response->getStatusCode());
    }

    public function forgotPasswordView(): View
    {
        return view('user.forgot-password');
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $response = new ApiResponse();

        $email = $request->input('email');

        try {
            $forgotPasswordUseCase = new ForgotPasswordUseCase(UserService::build());
            $forgotPasswordUseCase->execute($email);

            $response->setSuccess(true);
            $response->setStatusCode(HttpStatus::OK);

        } catch (BusinessRuleException | InvalidParameterException $e) {
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::BAD_REQUEST);
            $response->setMessage($e->getMessage());
        } catch (Exception $e) {
            Log::error("Falha ao recuperar senha: " . $e->getMessage());
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::INTERNAL_SERVER_ERROR);
            $response->setMessage('Erro Inesperado.');
        }

        return response()->json($response->toArray(), $response->getStatusCode());
    }
}