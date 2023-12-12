<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Date;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ValidateUpdateReminderInputTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function cannot_update_reminder_because_entity_not_found(): void
    {
        Date::setTestNow();
        Sanctum::actingAs(User::factory()->create(), ['access-api']);

        $response = $this->putJson('/api/reminders/1', [
            'title' => 'Title',
        ]);

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
    public function cannot_update_remind_at_n_event_at_when_the_values_are_not_unix_date(): void
    {
        Date::setTestNow();
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);
        $reminder = Reminder::factory()->belongsTo($user)->create();

        $response = $this->putJson("/api/reminders/$reminder->id", [
            'remind_at' => Date::now(),
            'event_at' => Date::now()->addDays(3),
        ]);

        $response
            ->assertBadRequest()
            ->assertJson([
                'ok' => false,
                'data' => [
                    'remind_at' => [__('validation.date_format', ['attribute' => 'remind at', 'format' => 'U'])],
                    'event_at' => [__('validation.date_format', ['attribute' => 'event at', 'format' => 'U'])],
                ],
                'err' => 'ERR_BAD_REQUEST',
                'msg' => 'invalid value of remind_at, event_at',
            ]);
    }

    /** @test */
    public function cannot_update_remind_at_if_its_greater_then_existing_event_at(): void
    {
        Date::setTestNow();
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);
        $reminder = Reminder::factory()->belongsTo($user)->create([
            'event_at' => $eventAt = Date::now()->addDays(3)->format('U'),
        ]);

        $response = $this->putJson("/api/reminders/$reminder->id", [
            'remind_at' => Date::now()->addDays(4)->format('U'),
        ]);

        $response
            ->assertBadRequest()
            ->assertJson([
                'ok' => false,
                'data' => [
                    'remind_at' => [__('validation.lt.numeric', ['attribute' => 'remind at', 'value' => $eventAt])],
                ],
                'err' => 'ERR_BAD_REQUEST',
                'msg' => 'invalid value of remind_at',
            ]);
    }

    /** @test */
    public function cannot_update_event_at_its_less_then_existing_remind_at(): void
    {
        Date::setTestNow();
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);
        $reminder = Reminder::factory()->belongsTo($user)->create([
            'remind_at' => $remindAt = Date::now()->addDays(3)->format('U'),
        ]);

        $response = $this->putJson("/api/reminders/$reminder->id", [
            'event_at' => Date::now()->format('U'),
        ]);

        $response
            ->assertBadRequest()
            ->assertJson([
                'ok' => false,
                'data' => [
                    'event_at' => [__('validation.gt.numeric', ['attribute' => 'event at', 'value' => $remindAt])],
                ],
                'err' => 'ERR_BAD_REQUEST',
                'msg' => 'invalid value of event_at',
            ]);
    }

    /** @test */
    public function cannot_update_remind_at_n_event_at_when_the_values_are_incorrect(): void
    {
        Date::setTestNow();
        Sanctum::actingAs($user = User::factory()->create(), ['access-api']);
        $reminder = Reminder::factory()->belongsTo($user)->create();

        $response = $this->putJson("/api/reminders/$reminder->id", [
            'remind_at' => $remindAt = Date::now()->addDays(2)->format('U'),
            'event_at' => $eventAt = Date::now()->format('U'),
        ]);

        $response
            ->assertBadRequest()
            ->assertJson([
                'ok' => false,
                'data' => [
                    'remind_at' => [__('validation.lt.numeric', ['attribute' => 'remind at', 'value' => $eventAt])],
                    'event_at' => [__('validation.gt.numeric', ['attribute' => 'event at', 'value' => $remindAt])],
                ],
                'err' => 'ERR_BAD_REQUEST',
                'msg' => 'invalid value of remind_at, event_at',
            ]);
    }
}
