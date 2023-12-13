<?php

namespace App\Http\Controllers\Api\Session;

use App\EAV\Entities\AccessTokenEntity;
use App\EAV\Entities\UserEntity;
use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\CredentialResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function __invoke(Request $request): CredentialResource|ErrorResource
    {
        $credential = $request->only('email', 'password');

        if (! Auth::attempt($credential)) {
            ErrorResource::withoutWrapping();

            return new ErrorResource('api.login');
        }

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
