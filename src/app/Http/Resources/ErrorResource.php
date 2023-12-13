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
     * Get HTTP error status code base on error values
     */
    public function getStatusCode(Request $request): int
    {
        if ($this->resource === 'api.login') {
            return Response::HTTP_UNAUTHORIZED;
        }

        if ($request->routeIs('api.token.issue')) {
            return Response::HTTP_UNAUTHORIZED;
        }

        if (array_key_exists('id', $this->resource->errors())) {
            if (str_contains($this->resource->errors()['id'][0], 'belongs to')) {
                return Response::HTTP_FORBIDDEN;
            }

            return Response::HTTP_NOT_FOUND;
        }

        return Response::HTTP_BAD_REQUEST;
    }

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

        if ($request->routeIs('api.token.issue')) {
            $error = AuthError::REFRESH;

            return [
                'ok' => false,
                'err' => $error->value,
                'msg' => $error->message(),
            ];
        }

        if ($this->resource instanceof ValidationException) {
            return (new HttpErrorEntity($this->resource->errors(), $this->getStatusCode()))->toArray();
        }

        return parent::toArray($request);
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->setStatusCode($this->getStatusCode($request));
    }
}
