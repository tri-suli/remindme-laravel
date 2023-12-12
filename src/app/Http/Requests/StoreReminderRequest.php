<?php

namespace App\Http\Requests;

use App\Http\Resources\ErrorResource;
use App\Services\AuthService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class StoreReminderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return AuthService::isAllowToMakeRequest($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'remind_at' => ['required', 'date_format:U', 'lt:event_at'],
            'event_at' => ['required', 'date_format:U', 'gt:remind_at'],
        ];
    }

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
