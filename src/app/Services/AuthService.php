<?php

namespace App\Services;

use App\Enums\TokenAbility;
use App\Models\User;
use App\Repositories\PersonalAccessTokenRepository;

class AuthService
{
    /**
     * Create a new service instance
     */
    public function __construct(public readonly PersonalAccessTokenRepository $tokenRepository)
    {
        //
    }

    /**
     * Get user access token
     */
    public function generateAccessToken(User $user): string
    {
        return $this->tokenRepository->createAccessToken($user);
    }

    /**
     * Get user refresh token
     */
    public function generateRefreshToken(User $user): string
    {
        return $this->tokenRepository->createRefreshToken($user);
    }

    /**
     * Determine if the current authenticated user's can do something
     */
    public function isAllowToMakeRequest(User $user): bool
    {
        return $user->tokenCan(TokenAbility::ACCESS_API->value);
    }
}
