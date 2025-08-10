<?php

namespace App\Application\Services\User;

use App\Domain\Entities\User;
use App\Domain\Entities\Uuid;
use App\Domain\Repositories\PasswordResetTokenRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Exceptions\BusinessRuleException;
use App\Infrastructure\Persistence\PasswordResetTokenRepository;
use App\Infrastructure\Persistence\UserRepository;
use App\Mail\PasswordRecoveryMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Contracts\User as SocialLoginUser;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private PasswordResetTokenRepositoryInterface $passwordResetTokenRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PasswordResetTokenRepositoryInterface $passwordResetTokenRepository
    ) {
        $this->userRepository = $userRepository;
        $this->passwordResetTokenRepository = $passwordResetTokenRepository;
    }

    public static function build(): UserService
    {
        return new self(new UserRepository(), new PasswordResetTokenRepository());
    }

    public function getUserByEmail(string $email): ?User
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new BusinessRuleException('E-mail Inválido');
        }

        return $this->userRepository->findByEmail($email);
    }

    public function createUserFromSocialLogin(SocialLoginUser $socialLoginUser, string $provider): User
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            'name' => $socialLoginUser->user['given_name'],
            'last_name' => $socialLoginUser->user['family_name'],
            'email' => $socialLoginUser->getEmail(),
            'email_verified_at' => $now,
            'provider' => $provider,
            'provider_id' => $socialLoginUser->getId(),
            'provider_token' => $socialLoginUser->token,
        ];

        return $this->userRepository->create($data);
    }

    public function createUser(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'email' => 'required|string|email|min:5|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'unique' => 'O :attribute já está em uso.',
        ]);

        if ($validator->fails()) {
            throw new BusinessRuleException($validator->errors()->first());
        }
        if ($data['password'] !== $data['password_confirmation']) {
            throw new BusinessRuleException('As senhas não conferem.');
        }

        unset($data['password_confirmation']);
        $data['password'] = Hash::make($data['password']);
        $data['uuid'] = Uuid::generateUuidV4();

        Log::info('Creating user with data: ', $data);

        $this->userRepository->create($data);
    }

    public function updateUser(int $userId, array $data): User
    {
        $data = array_filter($data);

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new BusinessRuleException('Usuário não encontrado.');
        }

        $user->name = $data['name'];
        $user->last_name = $data['last_name'];
        $user->save();

        return $user;
    }

    public function updateUserPassword(int $userId, array $data): User
    {
        $data = array_filter($data);

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new BusinessRuleException('Usuário não encontrado.');
        }

        if (!Hash::check($data['current_password'], $user->password)) {
            throw new BusinessRuleException('Senha atual inválida.');
        }

        if ($data['password'] !== $data['password_confirmation']) {
            throw new BusinessRuleException('As senhas não conferem.');
        }

        unset($data['password_confirmation']);
        $data['password'] = Hash::make($data['password']);

        $user->password = $data['password'];
        $user->save();

        return $user;
    }

    public function sendPasswordResetLink(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            throw new BusinessRuleException('Usuário não encontrado.');
        }

        $passwordResetToken = $this->passwordResetTokenRepository->findByEmail($email);
        if ($passwordResetToken) {
            if (!Carbon::parse($passwordResetToken->created_at)->addHour()->isPast()) {
                throw new BusinessRuleException('Um link de recuperação de senha já foi enviado para este e-mail. Verifique sua caixa de entrada ou spam.');
            }

            $passwordResetToken->delete();
        }
        
    
        $passwordResetToken = $this->passwordResetTokenRepository->create(
            [
                'email' => $email,
                'token' => bin2hex(random_bytes(16))
            ]
        );

        $passwordResetUrl = route('passwordRecovery');

        Mail::to($email)->send(new PasswordRecoveryMail($passwordResetUrl, $passwordResetToken->token));
    }

    public function passwordRecovery(string $token, string $password, string $passwordConfirmation): void
    {
        $passwordResetToken = $this->passwordResetTokenRepository->findByToken($token);
        if (!$passwordResetToken) {
            throw new BusinessRuleException('Token inválido.');
        }

        if (Carbon::parse($passwordResetToken->created_at)->addHour()->isPast()) {
            throw new BusinessRuleException('Token expirado.');
        }

        if ($password !== $passwordConfirmation) {
            throw new BusinessRuleException('As senhas não conferem.');
        }

        $user = $this->userRepository->findByEmail($passwordResetToken->email);
        if (!$user) {
            throw new BusinessRuleException('Usuário não encontrado.');
        }

        $user->password = Hash::make($password);
        $user->save();

        $passwordResetToken->delete();
    }
}
