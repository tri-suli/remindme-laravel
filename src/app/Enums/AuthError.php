<?php

namespace App\Enums;

enum AuthError: string
{
    /**
     * Error when login credential is invalid
     *
     * @var string
     */
    case LOGIN = 'ERR_INVALID_CREDS';

    /**
     * Error when refresh token is expired
     *
     * @var string
     */
    case REFRESH = 'ERR_INVALID_REFRESH_TOKEN';

    /**
     * Get error type message
     *
     * @return string
     */
    public function message(): string
    {
        return match ($this) {
            self::LOGIN => 'incorrect username or password',
            self::REFRESH => 'invalid refresh token',
        };
    }
}
