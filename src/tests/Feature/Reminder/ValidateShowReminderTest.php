<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ValidateShowReminderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cannot_show_reminder_by_id_because_resource_not_found(): void
    {
        Sanctum::actingAs(User::factory()->create(), ['access-api']);

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

    /** @test */
    public function cannot_show_reminder_record_because_its_not_belongs_to_current_user(): void
    {
        Sanctum::actingAs(User::factory()->create(), ['access-api']);
        $reminder = Reminder::factory()->belongsTo(User::factory()->create())->create();

        $response = $this->getJson("/api/reminders/$reminder->id");

        $response
            ->assertForbidden()
            ->assertJson([
                'ok' => false,
                'data' => [
                    'id' => ['The given id is not belongs to current user'],
                ],
                'err' => 'ERR_FORBIDDEN_ACCESS',
                'msg' => 'user doesn\'t have enough authorization',
            ]);
    }
}
