<?php

namespace App\Http\Resources;

use App\EAV\Entities\ReminderEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class ReminderResource extends JsonResource
{
    /**
     * The additional data
     *
     * @var array<string, mixed>
     */
    public $with = ['ok' => true];

    /**
     * Create a new HTTP resource
     */
    public function __construct(ReminderEntity $resource)
    {
        parent::__construct($resource);
    }

    /**
     * {@inheritDoc}
     */
    public function withResponse(Request $request, JsonResponse $response): void
    {
        if ($request->routeIs('api.reminder.store')) {
            $response->setStatusCode(Response::HTTP_CREATED);
        }

        parent::withResponse($request, $response);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
