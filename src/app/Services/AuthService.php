<?php

namespace App\Services;

use App\Enums\TokenAbility;
use App\Models\User;
use Illuminate\Support\Facades\Date;

class AuthService
{
    /**
     * The token ability to accessing the API
     *
     * @var TokenAbility
     */
    public readonly TokenAbility $accessToken;

    /**
     * The token ability to issuing the API access token
     *
     * @var TokenAbility
     */
    public readonly TokenAbility $refreshToken;

    /**
     * Create a new service instance
     */
    public function __construct()
    {
        $this->accessToken = TokenAbility::ACCESS_API;
        $this->refreshToken = TokenAbility::ISSUE_ACCESS_TOKEN;
    }

    /**
     * Get user access token
     */
    public function generateAccessToken(User $user): string
    {
        $token = $user->createToken(
            $this->accessToken->getName(),
            [$this->accessToken->value],
            Date::now()->addSeconds(config('sanctum.expiration'))
        );

        return $token->plainTextToken;
    }

    /**
     * Get user refresh token
     */
    public function generateRefreshToken(User $user): string
    {
        $token = $user->createToken(
            $this->refreshToken->getName(),
            [$this->refreshToken->value],
            Date::now()->addWeeks(config('sanctum.refresh_expiration'))
        );

        return $token->plainTextToken;
    }

    /**
     * Get all available tokens for current authenticated user's
     */
    public function getTokens(User $user): array
    {
        return [
            $this->accessToken->getName() => $this->generateAccessToken($user),
            $this->refreshToken->getName() => $this->generateRefreshToken($user),
        ];
    }
}
