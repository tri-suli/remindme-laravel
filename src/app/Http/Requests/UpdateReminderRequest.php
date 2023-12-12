<?php

namespace App\Http\Requests;

use App\Rules\BelongsToRule;
use App\Rules\EventReminderRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReminderRequest extends FormRequest
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
            'id' => ['bail', 'exists:reminders,id', new BelongsToRule($this->user()->id)],
            'title' => ['nullable'],
            'description' => ['nullable'],
            'remind_at' => ['nullable', 'date_format:U', new EventReminderRule($this->id, $this->get('event_at'))],
            'event_at' => ['nullable', 'date_format:U', new EventReminderRule($this->id, $this->get('remind_at'))],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['id' => $this->id]);
    }
}
