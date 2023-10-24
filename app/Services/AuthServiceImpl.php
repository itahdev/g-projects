<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\AuthService;
use App\Data\AuthUser;
use App\Exceptions\ApiException;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthServiceImpl implements AuthService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @param LoginRequest $request
     * @return AuthUser
     */
    public function login(LoginRequest $request): AuthUser
    {
        $user = $this->userRepository->findByEmail($request->input('email'));
        if (!$user && !Hash::check($request->input('password'), $user->password)) {
            throw ApiException::forbidden(trans('auth.failed'));
        }

        return $this->generateToken($user);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
    }

    /**
     * @param User $user
     * @return AuthUser
     */
    private function generateToken(User $user): AuthUser
    {
        $auth = Auth::guard();
        $token = $auth->fromUser($user);
        if (!$token) {
            throw ApiException::forbidden(trans('auth.failed'));
        }

        $expiresIn = $auth->factory()->getTTL() * 60;

        return new AuthUser($token, $expiresIn);
    }
}
