<?php

namespace App\Presentation\Http\Controllers\Web;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Utils\HttpStatus;
use App\Exceptions\AuthenticationException;
use App\Exceptions\BusinessRuleException;
use App\Exceptions\InvalidParameterException;
use App\Presentation\Http\Response\ApiResponse;
use App\Application\UseCases\Auth\LoginUseCase;
use App\Application\UseCases\Auth\LogoutUseCase;
use App\Application\Services\Auth\AuthService;
use App\Application\Services\User\UserService;
use App\Application\UseCases\Auth\SocialLoginUseCase;
use App\Presentation\Http\Request\Auth\LoginRequest;
use App\Presentation\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function loginView(): View
    {
        return view('auth.login');
    }

    public function socialLogin(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider)
    {
        $user = Socialite::driver($provider)->user();

        $socialLoginUseCase = new SocialLoginUseCase(AuthService::build(), UserService::build());
        $socialLoginUseCase->execute($user, $provider);

        return response()->make('Você pode fechar esta janela.<script>window.close()</script>');
    }

    public function login(LoginRequest $request)
    {
        $response = new ApiResponse();

        try{
            $email = $request->input('email');
            $password = $request->input('password');
            $remember = (bool) $request->input('remember');
    
            $loginUseCase = new LoginUseCase(AuthService::build());
            $loginUseCase->execute($email, $password, $remember);

            $response->setSuccess(true);
            $response->setStatusCode(HttpStatus::OK);
        } catch (BusinessRuleException | InvalidParameterException | AuthenticationException $e) {
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::BAD_REQUEST);
            $response->setMessage($e->getMessage());
        } catch (Exception $e) {
            Log::error("Falha ao autenticar: " . $e->getMessage());
            $response->setSuccess(false);
            $response->setStatusCode(HttpStatus::INTERNAL_SERVER_ERROR);
            $response->setMessage('Erro Inesperado.');
        }

        return response()->json($response->toArray(), $response->getStatusCode());
    }

    public function destroy(): RedirectResponse
    {
        try {
            $logoutUseCase = new LogoutUseCase();
            $logoutUseCase->execute();
        } catch (Throwable $th) {
            // Do Nothing
        } finally {
            return redirect('/');
        }
    }
}
