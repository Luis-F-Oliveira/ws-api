<?php

namespace Database\Factories;

use App\Models\Sector;
use App\Models\Command;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Command>
 */
class CommandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'return' => $this->faker->sentence,
            'sector_id' => Sector::pluck('id')->random(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Command $command) {
            if ($command->id === 1) {
                Command::factory()->count(4)->create([
                    'sector_id' => $command->sector_id,
                    'parent_id' => $command->id,
                ]);
            }

            if ($command->parent_id === 1) {
                Command::factory()->count(4)->create([
                    'sector_id' => $command->sector_id,
                    'parent_id' => $command->id,
                ]);
            }
        });
    }
}