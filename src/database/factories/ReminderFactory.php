<?php

namespace Database\Factories;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<Reminder>
 */
class ReminderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->text,
            'remind_at' => Date::now()->format('U'),
            'event_at' => Date::now()->addDays(7)->format('U'),
        ];
    }

    /**
     * Indicate that the model's is belongs to user
     */
    public function belongsTo(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user,
        ]);
    }
}
