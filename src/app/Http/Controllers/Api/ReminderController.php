<?php

namespace App\Http\Controllers\Api;

use App\EAV\Entities\ReminderEntity;
use App\Enums\TokenAbility;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShowReminderRequest;
use App\Http\Requests\StoreReminderRequest;
use App\Http\Requests\UpdateReminderRequest;
use App\Http\Resources\DeleteResource;
use App\Http\Resources\ReminderResource;
use App\Http\Resources\RemindersResource;
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
        $this->middleware([
            'auth:sanctum',
            sprintf('ability:%s', TokenAbility::ACCESS_API->value),
        ]);
        $this->repository = $repository;
    }

    /**
     * Handle request to view reminder list
     */
    public function index(Request $request): RemindersResource
    {
        return new RemindersResource(
            $this->repository->take($request->query('limit', 10))
        );
    }

    /**
     * Handle request to view reminder by id
     */
    public function show(ShowReminderRequest $request): ReminderResource
    {
        $reminder = $this->repository->find($request->id);

        return new ReminderResource(new ReminderEntity($reminder));
    }

    /**
     * Handle the incoming request.
     */
    public function store(StoreReminderRequest $request): ReminderResource
    {
        $values = $request->only(['title', 'description', 'remind_at', 'event_at']);

        $reminder = $this->repository->save([
            'user_id' => $request->user()->id,
            ...$values,
        ]);

        return new ReminderResource(new ReminderEntity($reminder));
    }

    /**
     * Handle update existing reminder resource by id.
     */
    public function update(UpdateReminderRequest $request): ReminderResource
    {
        $values = $request->only(['title', 'description', 'remind_at', 'event_at']);

        $reminder = $this->repository->update($request->id, $values);

        return new ReminderResource(new ReminderEntity($reminder));
    }

    /**
     * Handle delete existing reminder resource by id.
     */
    public function delete(ShowReminderRequest $request): DeleteResource
    {
        $this->repository->delete($request->id);

        return new DeleteResource();
    }
}
