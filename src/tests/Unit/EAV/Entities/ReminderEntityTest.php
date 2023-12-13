<?php

namespace Tests\Unit\EAV\Entities;

use App\EAV\Entities\ReminderEntity;
use App\Models\Reminder;
use PHPUnit\Framework\TestCase;

class ReminderEntityTest extends TestCase
{
    /** @test */
    public function can_create_reminder_entity(): void
    {
        $reminderMock = \Mockery::mock(Reminder::class);
        $reminderMock
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(1);
        $reminderMock
            ->shouldReceive('getAttribute')
            ->with('title')
            ->andReturn('Title');
        $reminderMock
            ->shouldReceive('getAttribute')
            ->with('description')
            ->andReturn('Description');
        $reminderMock
            ->shouldReceive('getAttribute')
            ->with('remind_at')
            ->andReturn(1701246722);
        $reminderMock
            ->shouldReceive('getAttribute')
            ->with('event_at')
            ->andReturn(1701223200);

        $entity = new ReminderEntity($reminderMock);

        $this->assertEquals(
            'Reminder, id: 1, title: Title, description: Description, remind_at: 1701246722, event_at: 1701223200',
            (string) $entity
        );
        $this->assertEquals([
            'id' => 1,
            'title' => 'Title',
            'description' => 'Description',
            'remind_at' => '1701246722',
            'event_at' => '1701223200',
        ], $entity->toArray());
    }
}
