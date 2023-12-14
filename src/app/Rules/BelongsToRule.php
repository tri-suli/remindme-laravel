<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\PotentiallyTranslatedString;

class BelongsToRule implements ValidationRule
{
    public function __construct(public readonly int $userId)
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
        $reminder = DB::table('reminders')->where('user_id', $this->userId)->first();

        if (is_null($reminder)) {
            $fail(sprintf('The given %s is not belongs to current user', $attribute));
        }
    }
}
