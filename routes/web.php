<?php

use Illuminate\Support\Facades\Route;
use App\Presentation\Http\Controllers\Web\UserController;
use App\Presentation\Http\Controllers\Web\AuthController;
use App\Presentation\Http\Middleware\RedirectIfAuthenticated;
use App\Presentation\Http\Middleware\RedirectIfNotAuthenticated;

Route::middleware(RedirectIfAuthenticated::class)->group(
    function () {
        # Password Reset
        Route::get('/login/forgot', [UserController::class, 'forgotPasswordView'])->name('forgotPasswordView');
        Route::post('/login/forgot', [UserController::class, 'forgotPassword'])->name('forgotPassword');

        Route::get('/login/recovery', [UserController::class, 'passwordRecoveryView'])->name('passwordRecoveryView');
        Route::post('/login/recovery', [UserController::class, 'passwordRecovery'])->name('passwordRecovery');

        # Login
        Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
        Route::post('/login', [AuthController::class, 'login'])->name('login');

        # Social Login
        Route::get('/login/{provider}', [AuthController::class, 'socialLogin'])->name('socialLogin');
        Route::get('/callback/{provider}', [AuthController::class, 'handleProviderCallback'])->name('socialLoginCallback');

        # Register
        Route::get('/register', [UserController::class, 'registerView'])->name('registerView');
        Route::post('/register', [UserController::class, 'register'])->name('register');
    }
); 

Route::middleware(RedirectIfNotAuthenticated::class)->group(
    function (): void {
        # Profile
        Route::get('profile', [UserController::class, 'profileView'])->name('profileView');
        Route::put('profile', [UserController::class, 'update'])->name('profileUpdate');

        Route::put('profile/password', [UserController::class, 'updatePassword'])->name('profileUpdatePassword');
    }
);

Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');
Route::get('/', action: function () { return view('index'); })->name('home');

# Debug
Route::get('is_authenticated', function () {
    if (\Auth::check()) {
        echo "Usuário está logado!";
    } else {
        echo "Usuário não está logado.";
    }
});