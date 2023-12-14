<?php

namespace Tests\Fixtures;

class TokenDataProvider
{
    /**
     * Get dummy access token
     */
    public static function accessToken(): string
    {
        return '933e89b1-980b-4c98-8d73-18f7ccfac25d';
    }

    /**
     * Get dummy refresh token
     */
    public static function refreshToken(): string
    {
        return '8eebef3c-03e0-4ead-b78e-27bac3fc43c3';
    }
}
