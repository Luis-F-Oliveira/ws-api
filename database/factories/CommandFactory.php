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
            $this->createCascadingCommands($command, 3);
        });
    }

    /**
     * Create cascading commands.
     *
     * @param  \App\Models\Command  $command
     * @param  int  $levels
     * @return void
     */
    private function createCascadingCommands(Command $command, int $levels)
    {
        dump('Level: ' . $levels);

        if ($levels <= 0) {
            return;
        }
    
        for ($level = 0; $level < $levels; $level++) {
            dump('Level: ' . $level); // Exibe o valor de $level no console
    
            $commandsToCreate = Command::factory(4)->create([
                'sector_id' => $command->sector_id,
                'parent_id' => $command->id,
            ]);

    
            foreach ($commandsToCreate as $newCommand) {
                $this->createCascadingCommands($newCommand, $levels - 1);
            }
        }
    }
}