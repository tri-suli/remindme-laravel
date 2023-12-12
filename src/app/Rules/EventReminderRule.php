<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\PotentiallyTranslatedString;

class EventReminderRule implements ValidationRule
{
    /**
     * Create a new rule instance
     */
    public function __construct(public readonly int $id, public readonly int|string|null $target)
    {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($this->target)) {
            $reminder = DB::table('reminders')
                ->select('remind_at', 'event_at')
                ->where('id', $this->id)
                ->first();

            if ($attribute === 'remind_at' && $value >= $reminder->event_at) {
                $fail(__('validation.lt.numeric', ['attribute' => 'remind at', 'value' => $reminder->event_at]));
            } elseif ($attribute === 'event_at' && $value <= $reminder->remind_at) {
                $fail(__('validation.gt.numeric', ['attribute' => 'event at', 'value' => $reminder->remind_at]));
            }
        } elseif (is_numeric($value)) {
            if ($attribute === 'remind_at' && $value >= $this->target) {
                $fail(__('validation.lt.numeric', ['attribute' => 'remind at', 'value' => $this->target]));
            } elseif ($attribute === 'event_at' && $value <= $this->target) {
                $fail(__('validation.gt.numeric', ['attribute' => 'event at', 'value' => $this->target]));
            }
        }
    }
}
