<?php

namespace App\Http\Resources;

use App\EAV\Entities\HttpErrorEntity;
use App\Enums\AuthError;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->resource === 'api.login') {
            $error = AuthError::LOGIN;

            return [
                'ok' => false,
                'err' => $error->value,
                'msg' => $error->message(),
            ];
        }

        if ($this->resource instanceof ValidationException) {
            return (new HttpErrorEntity($this->resource->errors()))->toArray();
        }

        return parent::toArray($request);
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        if ($this->resource === 'api.login') {
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
        } elseif ($this->resource instanceof ValidationException) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
