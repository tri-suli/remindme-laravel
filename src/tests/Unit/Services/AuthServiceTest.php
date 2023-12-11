<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\AuthService;
use Laravel\Sanctum\NewAccessToken;
use Mockery\MockInterface;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    /** @test */
    public function it_should_return_access_token_string(): void
    {
        $service = new AuthService();
        $userToken = $this->mock(NewAccessToken::class, function (MockInterface $mock) {
            $mock->plainTextToken = 'secret-access-token';
        });
        $user = $this->mock(User::class, function (MockInterface $mock) use ($userToken) {
            $mock->shouldReceive('createToken')
                ->andReturn($userToken);
        });

        $token = $service->generateAccessToken($user);

        $this->assertEquals('secret-access-token', $token);
    }

    /** @test */
    public function it_should_return_refresh_token_string(): void
    {
        $service = new AuthService();
        $userToken = $this->mock(NewAccessToken::class, function (MockInterface $mock) {
            $mock->plainTextToken = 'refresh-access-token';
        });
        $user = $this->mock(User::class, function (MockInterface $mock) use ($userToken) {
            $mock->shouldReceive('createToken')
                ->andReturn($userToken);
        });

        $token = $service->generateRefreshToken($user);

        $this->assertEquals('refresh-access-token', $token);
    }

    /** @test */
    public function it_will_return_access_token_n_refresh_token(): void
    {
        $service = new AuthService();
        $user = $this->spy(User::class, function (MockInterface $mock) {
            $accessToken = $this->mock(NewAccessToken::class, function (MockInterface $mock) {
                $mock->plainTextToken = 'secret-access-token';
            });
            $refreshToken = $this->mock(NewAccessToken::class, function (MockInterface $mock) {
                $mock->plainTextToken = 'secret-refresh-token';
            });
            $mock->shouldReceive('createToken')->andReturns($accessToken, $refreshToken);
        });

        $tokens = $service->getTokens($user);

        $this->assertEquals([
            'access_token' => 'secret-access-token',
            'refresh_token' => 'secret-refresh-token',
        ], $tokens);
        $user->shouldHaveReceived('createToken')->twice();
    }
}
