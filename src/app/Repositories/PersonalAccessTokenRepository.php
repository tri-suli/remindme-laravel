<?php

namespace App\Repositories;

use App\Enums\TokenAbility;
use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Support\Facades\Date;

class PersonalAccessTokenRepository extends Repository
{
    /**
     * Create a new access token record for user
     *
     * @param User $user
     * @return string
     */
    public function createAccessToken(User $user): string
    {
        $ability = TokenAbility::ACCESS_API;

        $token = $user->createToken(
            $ability->getName(),
            [$ability->value],
            Date::now()->addSeconds(config('sanctum.expiration'))
        );

        return $token->plainTextToken;
    }

    /**
     * Create a new refresh token record for user
     *
     * @param User $user
     * @return string
     */
    public function createRefreshToken(User $user): string
    {
        $ability = TokenAbility::ISSUE_ACCESS_TOKEN;

        $token = $user->createToken(
            $ability->getName(),
            [$ability->value],
            Date::now()->addWeeks(config('sanctum.refresh_expiration'))
        );

        return $token->plainTextToken;
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return PersonalAccessToken::class;
    }
}
