<?php

namespace App\EAV\Entities;

use App\EAV\Values\Description;
use App\EAV\Values\ID;
use App\EAV\Values\Timestamp;
use App\EAV\Values\Title;
use App\EAV\Entity;

class ReminderEntity extends Entity
{
    /**
     * Create a new reminder instance
     *
     * @param int $id
     * @param string $title
     * @param string $description
     * @param int $remindAt
     * @param int $eventAt
     */
    public function __construct(int $id, string $title, string $description, int $remindAt, int $eventAt)
    {
        parent::__construct('Reminder', [
            new ID($id),
            new Title($title),
            new Description($description),
            new Timestamp('remind', $remindAt),
            new Timestamp('event', $eventAt),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_values(parent::toArray())[0];
    }
}
