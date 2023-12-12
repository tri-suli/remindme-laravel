<?php

namespace App\Http\Requests;

use App\Http\Resources\ErrorResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * @extends FormRequest
 * @method expectsJson()
 */
trait WithCustomFailedValidation
{
    /**
     * {@inheritDoc}
     */
    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson()) {
            $resource = new ErrorResource(new ValidationException($validator));

            throw new HttpResponseException($resource->toResponse($this));
        }

        parent::failedValidation($validator);
    }
}
