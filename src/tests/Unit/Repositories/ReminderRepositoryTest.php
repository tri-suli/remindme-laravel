<?php

namespace Tests\Unit\Repositories;

use App\Models\Reminder;
use App\Models\User;
use App\Repositories\ReminderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;

class ReminderRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_should_create_a_new_reminder_record_into_database(): void
    {
        $record = [
            'user_id' => User::factory()->create()->id,
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->text,
            'remind_at' => $this->faker->date('U'),
            'event_at' => $this->faker->date('U'),
        ];
        $repository = new ReminderRepository();

        $result = $repository->save($record);

        $this->assertEquals($record['user_id'], $result->user_id);
        $this->assertEquals($record['title'], $result->title);
        $this->assertEquals($record['description'], $result->description);
        $this->assertEquals($record['remind_at'], $result->remind_at);
        $this->assertEquals($record['event_at'], $result->event_at);
    }

    /** @test  */
    public function it_will_update_existing_reminder_record_by_id(): void
    {
        $repository = new ReminderRepository();
        $user = User::factory()->create();
        $oldReminder = Reminder::factory()->belongsTo($user)->create();
        $values = [
            'title' => 'New Title',
            'description' => 'New Description',
            'remind_at' => Date::now()->format('U'),
            'event_at' => Date::now()->addDays(3)->format('U'),
        ];

        $newReminder = $repository->update($oldReminder->id, $values);

        $this->assertNotEquals(
            $newReminder->only('title', 'description', 'remind_at', 'event_at'),
            $oldReminder->only('title', 'description', 'remind_at', 'event_at'),
        );
        $this->assertDatabaseMissing('reminders', $oldReminder->only('title', 'description', 'remind_at', 'event_at'));
        $this->assertDatabaseHas('reminders', $values);
    }

    /** @test */
    public function it_will_delete_existing_reminder_record_from_database(): void
    {
        $repository = new ReminderRepository();
        $user = User::factory()->create();
        $reminder = Reminder::factory()->belongsTo($user)->create();

        $deleted = $repository->delete($reminder->id);

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('reminders', $reminder->only([
            'id', 'title', 'description', 'remind_at', 'event_at',
        ]));
    }
}
