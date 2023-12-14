<?php

namespace Tests\Unit\EAV\Entities;

use App\EAV\Entities\AccessTokenEntity;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\TokenDataProvider;

class AccessTokenEntityTest extends TestCase
{
    /** @test */
    public function it_will_return_access_token_entity_as_a_string(): void
    {
        $accessToken = TokenDataProvider::accessToken();
        $refreshToken = TokenDataProvider::refreshToken();
        $entity = new AccessTokenEntity($accessToken, $refreshToken);

        $this->assertEquals(
            "Token, access_token: $accessToken, refresh_token: $refreshToken",
            (string) $entity
        );
    }

    /** @test */
    public function it_will_return_access_token_entity_as_array(): void
    {
        $accessToken = TokenDataProvider::accessToken();
        $refreshToken = TokenDataProvider::refreshToken();
        $entity = new AccessTokenEntity($accessToken, $refreshToken);

        $this->assertEquals(
            ['access_token' => $accessToken, 'refresh_token' => $refreshToken],
            $entity->toArray()
        );
    }

    /** @test */
    public function it_will_only_return_access_token_when_refresh_token_is_empty(): void
    {
        $accessToken = TokenDataProvider::accessToken();
        $entity = new AccessTokenEntity($accessToken);

        $this->assertEquals(
            "Token, access_token: $accessToken, refresh_token: ",
            (string) $entity
        );
        $this->assertEquals(
            ['access_token' => $accessToken],
            $entity->toArray()
        );
    }
}
