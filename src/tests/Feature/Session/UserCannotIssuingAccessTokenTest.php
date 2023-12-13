<?php

namespace Tests\Feature\Session;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCannotIssuingAccessTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_receive_unauthorized_response_when_theres_no_refresh_token_provide(): void
    {
        Sanctum::actingAs(User::factory()->create(), ['access-api']);

        $response = $this->putJson('api/session');

        $response
            ->assertUnauthorized()
            ->assertJson([
                'ok' => false,
                'err' => 'ERR_INVALID_REFRESH_TOKEN',
                'msg' => 'invalid refresh token',
            ]);
    }
}
