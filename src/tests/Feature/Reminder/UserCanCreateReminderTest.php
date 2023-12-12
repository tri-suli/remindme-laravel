<?php

namespace Tests\Feature\Reminder;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Date;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCanCreateReminderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function can_create_reminder(): void
    {
        Date::setTestNow();
        $input = [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->sentence,
            'remind_at' => Date::now()->format('U'),
            'event_at' => Date::now()->format('U'),
        ];
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['access-api']);

        $response = $this->postJson('/api/reminders', $input);

        $response
            ->assertCreated()
            ->assertJson([
                'ok' => true,
                'data' => $input,
            ]);
    }
}
