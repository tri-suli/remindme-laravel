<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCanDeleteExistingReminderRecordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_receive_http_ok_response_when_record_is_deleted(): void
    {
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);
        $reminder = Reminder::factory()->belongsTo($user)->create();

        $response = $this->deleteJson("/api/reminders/$reminder->id");

        $response
            ->assertOk()
            ->assertJson(['ok' => true]);
    }
}
