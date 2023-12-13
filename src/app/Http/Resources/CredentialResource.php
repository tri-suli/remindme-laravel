<?php

namespace App\Http\Resources;

use App\EAV\Entities\AccessTokenEntity;
use App\EAV\Entities\UserEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CredentialResource extends JsonResource
{
    /**
     * Don't wrap the response data with `data` key
     *
     * @var string|null
     */
    public static $wrap = null;

    /**
     * {@inheritDoc}
     */
    public function __construct(UserEntity $user = null, AccessTokenEntity $token = null)
    {
        $resource = ['data' => []];

        if (! is_null($user)) {
            $resource['data']['user'] = $user->toArray();
        }

        if (! is_null($token)) {
            $resource['data'] = [
                ...$resource['data'],
                ...$token->toArray(),
            ];
        }

        parent::__construct(['ok' => true, ...$resource]);
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
