<?php

namespace App\Http\Controllers\Api\Session;

use App\EAV\Entities\AccessTokenEntity;
use App\Enums\TokenAbility;
use App\Http\Controllers\Controller;
use App\Http\Resources\CredentialResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    public readonly AuthService $auth;

    /**
     * Create a new controller instance
     */
    public function __construct(AuthService $auth)
    {
        $this->middleware([
            'auth:sanctum',
            sprintf('ability:%s', TokenAbility::ISSUE_ACCESS_TOKEN->value),
        ]);
        $this->auth = $auth;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): CredentialResource
    {
        $token = $this->auth->generateAccessToken($request->user());

        return new CredentialResource(new AccessTokenEntity($token));
    }
}
