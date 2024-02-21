<?php

namespace Database\Factories;

use App\Models\Sector;
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
            'name' => Str::random(10),
            'return' => Str::random(25),
            'sector_id' => function () {
                return Sector::pluck('id')->random();
            }
        ];
    }
}
