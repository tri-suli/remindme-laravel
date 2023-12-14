<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCanViewReminderListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_take_10_reminders_by_default(): void
    {
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);
        Reminder::factory(15)->belongsTo($user)->create();

        $response = $this->getJson('/api/reminders');

        $response
            ->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('data.limit', 10)
            ->assertJsonCount(10, 'data.reminders');
    }

    /** @test */
    public function it_will_take_5_reminders_even_there_are_10_reminders_record(): void
    {
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);
        Reminder::factory(10)->belongsTo($user)->create();

        $response = $this->getJson('/api/reminders?limit=5');

        $response
            ->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('data.limit', 5)
            ->assertJsonCount(5, 'data.reminders');
    }

    /** @test */
    public function it_will_return_empty_reminders_even_the_query_limit_params_is_set_to_15(): void
    {
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);

        $response = $this->getJson('/api/reminders?limit=15');

        $response
            ->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('data.limit', 15)
            ->assertJsonCount(0, 'data.reminders');
    }
}
