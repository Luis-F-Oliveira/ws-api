<?php

namespace Database\Factories;

use App\Models\Command;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commit>
 */
class CommitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::pluck('id')->random();
            },
            'command_id' => function () {
                return Command::pluck('id')->random();
            },
            'number_from' => '5565999999999'
        ];
    }
}
