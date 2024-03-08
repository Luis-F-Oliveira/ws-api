<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Access::factory(3)->create();
        \App\Models\Sector::factory(2)->create();
        \App\Models\User::factory(1)->create();
        \App\Models\Command::factory(1)->create();
    }
}
