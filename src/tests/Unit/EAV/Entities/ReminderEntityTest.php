<?php

namespace Tests\Unit\EAV\Entities;

use App\EAV\Entities\ReminderEntity;
use PHPUnit\Framework\TestCase;

class ReminderEntityTest extends TestCase
{
    /** @test */
    public function can_create_reminder_entity(): void
    {
        $entity = new ReminderEntity(
            1,
            'Title',
            'Description',
            1701246722,
            1701223200,
        );

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
