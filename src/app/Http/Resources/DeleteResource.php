<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeleteResource extends JsonResource
{
    /**
     * {@inheritdoc}
     */
    public $with = ['ok' => true];

    /**
     * {@inheritdoc}
     */
    public static $wrap = null;

    /**
     * {@inheritDoc}
     */
    public function __construct($resource = [])
    {
        parent::__construct($resource);
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
