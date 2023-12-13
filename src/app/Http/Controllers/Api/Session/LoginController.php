<?php

namespace App\Http\Controllers\Api\Session;

use App\EAV\Entities\AccessTokenEntity;
use App\EAV\Entities\UserEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\CredentialResource;
use App\Services\AuthService;

class LoginController extends Controller
{
    /**
     * Auth service instance
     *
     * @var AuthService
     */
    public readonly AuthService $authService;

    /**
     * Create a new controller instance
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->middleware('guest');
        $this->authService = $authService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): CredentialResource
    {
        $user = $request->user();

        return new CredentialResource(
            new UserEntity($user->id, $user->name, $user->email),
            new AccessTokenEntity(
                $this->authService->generateAccessToken($user),
                $this->authService->generateRefreshToken($user)
            )
        );
    }
}
