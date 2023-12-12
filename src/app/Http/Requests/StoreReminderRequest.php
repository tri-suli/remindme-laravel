<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReminderRequest extends FormRequest
{
    use WithAccessApi, WithCustomFailedValidation;

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
}
