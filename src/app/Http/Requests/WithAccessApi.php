<?php

namespace App\Http\Requests;

use App\Services\AuthService;

/**
 * @method user() Get the user making the request
 */
trait WithAccessApi
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return AuthService::isAllowToMakeRequest($this->user());
    }
}
