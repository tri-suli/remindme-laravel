<?php

namespace App\Enums;

enum TokenAbility: string
{
    /** Ability type to refreshing the token */
    case ISSUE_ACCESS_TOKEN = 'issue-access-token';

    /** Ability type to accessing the API */
    case ACCESS_API = 'access-api';

    /**
     * Get token's name
     *
     * @return string
     */
    public function getName(): string
    {
        return match ($this) {
            self::ACCESS_API => 'access_token',
            self::ISSUE_ACCESS_TOKEN => 'refresh_token',
        };
    }
}
