<?php

namespace Tests\Feature\Session;

use App\Enums\TokenAbility;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;
use Tests\Fixtures\TokenDataProvider;
use Tests\TestCase;

class UserCanRefreshAccessTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_re_generate_access_token_when_refresh_token_is_still_valid(): void
    {
        $user = Sanctum::actingAs(User::factory()->create(), TokenAbility::abilities());
        $this->mock(AuthService::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('generateAccessToken')
                ->withArgs(fn ($param) => $param->id === $user->id)
                ->andReturn(TokenDataProvider::accessToken());
        });

        $response = $this->putJson('api/session');

        $response
            ->assertStatus(200)
            ->assertJson([
                'ok' => true,
                'data' => [
                    'access_token' => TokenDataProvider::accessToken(),
                ],
            ]);
    }
}
