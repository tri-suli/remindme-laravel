<?php

namespace Tests\Unit\Enums;

use App\Enums\AuthError;
use PHPUnit\Framework\TestCase;

class AuthErrorTest extends TestCase
{
    /** @test */
    public function the_error_message_should_contains_username_n_password(): void
    {
        $error = AuthError::LOGIN;

        $this->assertEquals('ERR_INVALID_CREDS', $error->value);
        $this->assertStringContainsString('username', $error->message());
        $this->assertStringContainsString('password', $error->message());
    }

    /** @test */
    public function the_error_message_should_contains_refresh_token(): void
    {
        $error = AuthError::REFRESH;

        $this->assertEquals('ERR_INVALID_REFRESH_TOKEN', $error->value);
        $this->assertStringContainsString('refresh token', $error->message());
    }
}
