<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\ReminderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
