<?php

namespace App\Http\Controllers\V1;

use App\Contracts\Services\AuthService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Resources\AuthResource;
use App\Resources\Base\ErrorResource;
use App\Resources\Base\SuccessResource;
use OpenApi\Attributes as OA;

class AuthController extends BaseController
{
    /** @var AuthService */
    private AuthService $authService;

    /**
     * AuthController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    #[OA\Post(
        path: '/v1/auth/login',
        summary: 'User login.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: LoginRequest::class)
        ),
        tags: ['AUTH'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful',
                content: new OA\JsonContent(ref: AuthResource::class)
            ),
            new OA\Response(
                response: 403,
                description: 'Login failed',
                content: new OA\JsonContent(ref: ErrorResource::class)
            ),
            new OA\Response(
                response: 422,
                description: 'The email field is required',
                content: new OA\JsonContent(ref: ErrorResource::class)
            ),
            new OA\Response(
                response: 500,
                description: 'Server error',
                content: new OA\JsonContent(ref: ErrorResource::class)
            )
        ]
    )]
    public function login(LoginRequest $request): AuthResource
    {
        $auth = $this->authService->login($request);

        return AuthResource::make($auth);
    }

    #[OA\Post(
        path: '/v1/auth/logout',
        summary: 'User logout.',
        security: [['BearerAuth' => []]],
        tags: ['AUTH'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful',
                content: new OA\JsonContent(ref: SuccessResource::class)
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request',
                content: new OA\JsonContent(ref: ErrorResource::class)
            ),
            new OA\Response(
                response: 401,
                description: 'Auth unauthenticated',
                content: new OA\JsonContent(ref: ErrorResource::class)
            ),
            new OA\Response(
                response: 500,
                description: 'Server error',
                content: new OA\JsonContent(ref: ErrorResource::class)
            )
        ]
    )]
    public function logout(): SuccessResource
    {
        $this->authService->logout();

        return SuccessResource::make();
    }
}
