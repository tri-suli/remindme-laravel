<?php

namespace Tests\Feature\Reminder;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Date;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ValidateReminderInputTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_will_receive_validation_error_for_input_title(): void
    {
        Date::setTestNow();
        $input = [
            'description' => $this->faker->sentence,
            'remind_at' => Date::now()->format('U'),
            'event_at' => Date::now()->addDays(3)->format('U'),
        ];
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->postJson('/api/reminders', $input);

        $response
            ->assertBadRequest()
            ->assertJson([
                'ok' => false,
                'data' => [
                    'title' => [__('validation.required', ['attribute' => 'title'])],
                ],
                'err' => 'ERR_BAD_REQUEST',
                'msg' => 'invalid value of title',
            ]);
    }

    /** @test */
    public function it_will_receive_validation_error_for_input_description(): void
    {
        Date::setTestNow();
        $input = [
            'title' => $this->faker->jobTitle,
            'remind_at' => Date::now()->format('U'),
            'event_at' => Date::now()->addDays(3)->format('U'),
        ];
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->postJson('/api/reminders', $input);

        $response
            ->assertBadRequest()
            ->assertJson([
                'ok' => false,
                'data' => [
                    'description' => [__('validation.required', ['attribute' => 'description'])],
                ],
                'err' => 'ERR_BAD_REQUEST',
                'msg' => 'invalid value of description',
            ]);
    }

    /** @test */
    public function it_will_receive_validation_error_for_input_remind_at_n_event_at(): void
    {
        Date::setTestNow();
        $input = [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->sentence,
        ];
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->postJson('/api/reminders', $input);

        $response
            ->assertBadRequest()
            ->assertJson([
                'ok' => false,
                'data' => [
                    'remind_at' => [__('validation.required', ['attribute' => 'remind at'])],
                    'event_at' => [__('validation.required', ['attribute' => 'event at'])],
                ],
                'err' => 'ERR_BAD_REQUEST',
                'msg' => 'invalid value of remind_at, event_at',
            ]);
    }

    /** @test */
    public function it_will_receive_validation_error_for_input_remind_at_n_event_at_when_the_values_are_not_unix_date(): void
    {
        Date::setTestNow();
        $input = [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->sentence,
            'remind_at' => Date::now(),
            'event_at' => Date::now()->addDays(3),
        ];
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->postJson('/api/reminders', $input);

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
    public function it_will_receive_validation_error_for_input_remind_at_when_its_not_less_then_event_at(): void
    {
        Date::setTestNow();
        $input = [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->sentence,
            'event_at' => $eventAt = Date::now()->format('U'),
            'remind_at' => $remindAt = Date::now()->addDays(3)->format('U'),
        ];
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->postJson('/api/reminders', $input);

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

    /** @test */
    public function it_will_receive_validation_error_for_input_event_at_when_its_not_greater_then_remind_at(): void
    {
        Date::setTestNow();
        $input = [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->sentence,
            'event_at' => $eventAt = Date::now()->format('U'),
            'remind_at' => $remindAt = Date::now()->format('U'),
        ];
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->postJson('/api/reminders', $input);

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
