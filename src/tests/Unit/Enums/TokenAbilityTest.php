<?php

namespace Tests\Unit\Enums;

use App\Enums\TokenAbility;
use PHPUnit\Framework\TestCase;

class TokenAbilityTest extends TestCase
{
    /** @test */
    public function it_should_return_string_access_token(): void
    {
        $token = TokenAbility::ACCESS_API;

        $this->assertEquals('access-api', $token->value);
        $this->assertEquals('access_token', $token->getName());
    }

    /** @test */
    public function it_should_return_string_refresh_token(): void
    {
        $token = TokenAbility::ISSUE_ACCESS_TOKEN;

        $this->assertEquals('issue-access-token', $token->value);
        $this->assertEquals('refresh_token', $token->getName());
    }
}
