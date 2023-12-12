<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCanShowReminderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_show_reminder_by_id(): void
    {
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);
        $reminder = Reminder::factory()->belongsTo($user)->create();

        $response = $this->getJson("/api/reminders/$reminder->id");

        $response
            ->assertOk()
            ->assertJson([
                'ok' => true,
                'data' => $reminder->only('id', 'title', 'description', 'remind_at', 'event_at'),
            ]);
    }

    /** @test */
    public function cannot_show_reminder_by_id_because_resource_not_found(): void
    {
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);

        $response = $this->getJson('/api/reminders/1');

        $response
            ->assertNotFound()
            ->assertJson([
                'ok' => false,
                'data' => [
                    'id' => [__('validation.exists', ['attribute' => 'id'])],
                ],
                'err' => 'ERR_NOT_FOUND',
                'msg' => 'resource is not found',
            ]);
    }
}
