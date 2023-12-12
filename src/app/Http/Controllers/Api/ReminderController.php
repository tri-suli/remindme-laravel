<?php

namespace App\Http\Controllers\Api;

use App\EAV\Entities\ReminderEntity;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReminderResource;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * Reminder repository
     *
     * @see \App\Providers\AppServiceProvider::boot() Check contextual binding at line 29-32
     */
    public readonly Repository $repository;

    /**
     * Create a new controller instance
     */
    public function __construct(Repository $repository)
    {
        $this->middleware('auth:sanctum');
        $this->repository = $repository;
    }

    /**
     * Handle the incoming request.
     */
    public function store(Request $request): ReminderResource
    {
        $values = $request->only(['title', 'description', 'remind_at', 'event_at']);

        $reminder = $this->repository->save([
            'user_id' => $request->user()->id,
            ...$values,
        ]);

        return new ReminderResource(
            new ReminderEntity(
                $reminder->id,
                $reminder->title,
                $reminder->description,
                $reminder->remind_at,
                $reminder->event_at
            )
        );
    }
}
