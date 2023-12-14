<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Repositories\PersonalAccessTokenRepository;
use App\Services\AuthService;
use Laravel\Sanctum\NewAccessToken;
use Mockery\MockInterface;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    /** @test */
    public function it_should_return_access_token_string(): void
    {
        $userToken = $this->mock(NewAccessToken::class, function (MockInterface $mock) {
            $mock->plainTextToken = 'secret-access-token';
        });
        $user = $this->mock(User::class, function (MockInterface $mock) use ($userToken) {
            $mock->shouldReceive('createToken')
                ->andReturn($userToken);
        });
        $tokenRepository = $this->spy(PersonalAccessTokenRepository::class, function (MockInterface $mock) use ($userToken) {
            $mock->shouldReceive('createAccessToken')
                ->andReturn($userToken->plainTextToken);
        });
        $service = new AuthService($tokenRepository);

        $token = $service->generateAccessToken($user);

        $this->assertEquals('secret-access-token', $token);
        $tokenRepository
            ->shouldHaveReceived('createAccessToken')
            ->once();
    }

    /** @test */
    public function it_should_return_refresh_token_string(): void
    {
        $userToken = $this->mock(NewAccessToken::class, function (MockInterface $mock) {
            $mock->plainTextToken = 'secret-refresh-token';
        });
        $user = $this->mock(User::class, function (MockInterface $mock) use ($userToken) {
            $mock->shouldReceive('createToken')
                ->andReturn($userToken);
        });
        $tokenRepository = $this->spy(PersonalAccessTokenRepository::class, function (MockInterface $mock) use ($userToken) {
            $mock->shouldReceive('createRefreshToken')
                ->andReturn($userToken->plainTextToken);
        });
        $service = new AuthService($tokenRepository);

        $token = $service->generateRefreshToken($user);

        $this->assertEquals('secret-refresh-token', $token);
        $tokenRepository
            ->shouldHaveReceived('createRefreshToken')
            ->once();
    }
}
