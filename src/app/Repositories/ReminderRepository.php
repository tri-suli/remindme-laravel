<?php

namespace App\Repositories;

use App\EAV\Entities\ReminderEntity;
use App\Models\Reminder;

class ReminderRepository extends Repository
{
    /**
     * Store a new reminder resource
     */
    public function save(array $attributes): Reminder
    {
        foreach ($attributes as $field => $value) {
            $this->model[$field] = $value;
        }

        $this->model->save();

        return $this->model;
    }

    /**
     * {@inheritDoc}
     */
    public function toEntity(): ReminderEntity
    {
        return new ReminderEntity(
            $this->model->id,
            $this->model->title,
            $this->model->description,
            $this->model->remind_at,
            $this->model->event_at
        );
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Reminder::class;
    }
}
