<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\PersonalAccessTokenRepository;
use Laravel\Sanctum\NewAccessToken;
use Mockery\MockInterface;
use Tests\TestCase;

class PersonalAccessTokenRepositoryTest extends TestCase
{
    private PersonalAccessTokenRepository $repository;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new PersonalAccessTokenRepository();
    }

    /** @test */
    public function it_will_return_plain_text_access_token(): void
    {
        $userToken = $this->mock(NewAccessToken::class, function (MockInterface $mock) {
            $mock->plainTextToken = 'secret-access-token';
        });
        $user = $this->mock(User::class, function (MockInterface $mock) use ($userToken) {
            $mock->shouldReceive('createToken')
                ->andReturn($userToken);
            $mock->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn(1);
        });

        $token = $this->repository->createAccessToken($user);

        $this->assertEquals('secret-access-token', $token);
    }

    /** @test */
    public function it_will_return_plain_text_refresh_token(): void
    {
        $userToken = $this->mock(NewAccessToken::class, function (MockInterface $mock) {
            $mock->plainTextToken = 'secret-refresh-token';
        });
        $user = $this->mock(User::class, function (MockInterface $mock) use ($userToken) {
            $mock->shouldReceive('createToken')
                ->andReturn($userToken);
        });

        $token = $this->repository->createAccessToken($user);

        $this->assertEquals('secret-refresh-token', $token);
    }
}
