<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(2)->state(
            new Sequence(
                ['name' => 'alice', 'email' => 'alice@mail.com'],
                ['name' => 'bob', 'email' => 'bob@mail.com'],
            )
        )->create();
    }
}
