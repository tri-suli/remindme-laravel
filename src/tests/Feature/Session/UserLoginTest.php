<?php

namespace Tests\Feature\Session;

use App\Enums\AuthError;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_will_receive_access_token_n_refresh_token_when_login_credential_is_matches(): void
    {
        $email = $this->faker->email;
        $user = User::factory()->create(['email' => $email]);
        $this->mock(AuthService::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('getTokens')
                ->withArgs(fn ($param) => $param->id === $user->id)
                ->andReturn([
                    'access_token' => 'secret-access-token',
                    'refresh_token' => 'secret-refresh-token',
                ]);
        });

        $response = $this->postJson('api/session', [
            'email' => $email,
            'password' => '123456',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'ok' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name,
                    ],
                    'access_token' => 'secret-access-token',
                    'refresh_token' => 'secret-refresh-token',
                ],
            ]);
    }

    /** @test */
    public function it_will_receive_un_authorized_response_when_login_credential_is_mismatch(): void
    {
        $error = AuthError::LOGIN;
        $response = $this->postJson('api/session', [
            'email' => $this->faker->email,
            'password' => '123456',
        ]);

        $response
            ->assertUnauthorized()
            ->assertJson([
                'ok' => false,
                'err' => $error->value,
                'msg' => $error->message(),
            ]);
    }
}
