<?php

namespace App\Http\Controllers\Api\Session;

use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\TokenResource;
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
    public function __invoke(Request $request): TokenResource|ErrorResource
    {
        $credential = $request->only('email', 'password');

        if (! Auth::attempt($credential)) {
            ErrorResource::withoutWrapping();

            return new ErrorResource('api.login');
        }

        $user = $request->user();

        return new TokenResource([
            'ok' => true,
            'data' => [
                'user' => $user->only('id', 'email', 'name'),
                ...$this->authService->getTokens($user),
            ],
        ]);
    }
}
