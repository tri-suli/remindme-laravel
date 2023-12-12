<?php

namespace App\Http\Resources;

use App\EAV\Entities\ReminderEntity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RemindersResource extends ResourceCollection
{
    /**
     * The additional data
     *
     * @var array<string, mixed>
     */
    public $with = ['ok' => true];

    /**
     * Create a new resource instance
     */
    public function __construct(Collection $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'reminders' => $this->resource->transform(fn ($reminder) => new ReminderEntity(
                $reminder->id,
                $reminder->title,
                $reminder->description,
                $reminder->remind_at,
                $reminder->event_at
            ))->toArray(),
            'limit' => intval($request->query('limit', 10))
        ];
    }
}
