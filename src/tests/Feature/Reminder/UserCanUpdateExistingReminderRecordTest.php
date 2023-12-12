<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Date;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCanUpdateExistingReminderRecordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function can_only_update_reminder_title(): void
    {
        $title = $this->faker->jobTitle;
        $user = User::factory()->create();
        $reminder = Reminder::factory()->belongsTo($user)->create();
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->putJson("api/reminders/$reminder->id", [
            'title' => $title,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'ok' => true,
                'data' => [
                    'title' => $title,
                    ...$reminder->only('description', 'remind_at', 'event_at'),
                ],
            ]);
    }

    /** @test */
    public function can_only_update_reminder_description(): void
    {
        $description = $this->faker->text;
        $user = User::factory()->create();
        $reminder = Reminder::factory()->belongsTo($user)->create();
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->putJson("api/reminders/$reminder->id", [
            'description' => $description,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'ok' => true,
                'data' => [
                    'description' => $description,
                    ...$reminder->only('title', 'remind_at', 'event_at'),
                ],
            ]);
    }

    /** @test */
    public function can_only_update_reminder_remind_at(): void
    {
        $remindAt = Date::now()->format('U');
        $user = User::factory()->create();
        $reminder = Reminder::factory()->belongsTo($user)->create([
            'remind_at' => Date::now()->addDays(1)->format('U'),
            'event_at' => Date::now()->addDays(3)->format('U'),
        ]);
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->putJson("api/reminders/$reminder->id", [
            'remind_at' => $remindAt,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'ok' => true,
                'data' => [
                    'remind_at' => $remindAt,
                    ...$reminder->only('title', 'description', 'event_at'),
                ],
            ]);
    }

    /** @test */
    public function can_only_update_reminder_event_at(): void
    {
        $eventAt = Date::now()->addDays(3)->format('U');
        $user = User::factory()->create();
        $reminder = Reminder::factory()->belongsTo($user)->create([
            'remind_at' => Date::now()->format('U'),
            'event_at' => Date::now()->addDays(1)->format('U'),
        ]);
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->putJson("api/reminders/$reminder->id", [
            'event_at' => $eventAt,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'ok' => true,
                'data' => [
                    'event_at' => $eventAt,
                    ...$reminder->only('title', 'description', 'remind_at'),
                ],
            ]);
    }

    /** @test */
    public function can_only_update_all_reminder_fields(): void
    {
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);
        $reminder = Reminder::factory()->belongsTo($user)->create();
        $newReminder = [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->text,
            'remind_at' => Date::now()->addDays(1)->format('U'),
            'event_at' => Date::now()->addDays(4)->format('U'),
        ];

        $response = $this->putJson("api/reminders/$reminder->id", $newReminder);

        $response
            ->assertStatus(200)
            ->assertJson(['ok' => true, 'data' => $newReminder]);
    }
}
