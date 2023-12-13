<?php

namespace Tests\Unit\Http\Resources;

use App\EAV\Entities\AccessTokenEntity;
use App\EAV\Entities\UserEntity;
use App\Http\Resources\CredentialResource;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\TokenDataProvider;

class CredentialResourceTest extends TestCase
{
    /** @test */
    public function it_will_return_access_token_n_refresh_token_instance_as_array(): void
    {
        $requestMock = \Mockery::mock(Request::class);
        $resource = new CredentialResource(
            null,
            new AccessTokenEntity(TokenDataProvider::accessToken(), TokenDataProvider::refreshToken())
        );

        $this->assertEquals([
            'ok' => true,
            'data' => [
                'access_token' => TokenDataProvider::accessToken(),
                'refresh_token' => TokenDataProvider::refreshToken(),
            ],
        ], $resource->toArray($requestMock));
    }

    /** @test */
    public function it_will_return_access_token_instance_as_array(): void
    {
        $requestMock = \Mockery::mock(Request::class);
        $resource = new CredentialResource(
            null,
            new AccessTokenEntity(TokenDataProvider::accessToken())
        );

        $this->assertEquals([
            'ok' => true,
            'data' => [
                'access_token' => TokenDataProvider::accessToken(),
            ],
        ], $resource->toArray($requestMock));
    }

    /** @test */
    public function it_will_return_user_entity_instance_as_array_with_access_tokens(): void
    {
        $userId = 1;
        $userName = 'John Lark';
        $userEmail = 'johnlark@mail.com';
        $requestMock = \Mockery::mock(Request::class);
        $resource = new CredentialResource(
            new UserEntity($userId, $userName, $userEmail),
            new AccessTokenEntity(TokenDataProvider::accessToken(), TokenDataProvider::refreshToken())
        );

        $this->assertEquals([
            'ok' => true,
            'data' => [
                'user' => [
                    'id' => $userId,
                    'name' => $userName,
                    'email' => $userEmail,
                ],
                'access_token' => TokenDataProvider::accessToken(),
                'refresh_token' => TokenDataProvider::refreshToken(),
            ],
        ], $resource->toArray($requestMock));
    }
}
