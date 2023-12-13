<?php

namespace App\EAV\Entities;

use App\EAV\Entity;
use App\EAV\Values\Description;
use App\EAV\Values\ID;
use App\EAV\Values\Timestamp;
use App\EAV\Values\Title;
use App\Models\Reminder;

class ReminderEntity extends Entity
{
    /**
     * Create a new reminder instance
     *
     * @param Reminder $model
     */
    public function __construct(Reminder $model)
    {
        parent::__construct('Reminder', [
            new ID($model->id),
            new Title($model->title),
            new Description($model->description),
            new Timestamp('remind', $model->remind_at),
            new Timestamp('event', $model->event_at),
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
