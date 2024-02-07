<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Recipe::factory(10)
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 6))
            ->create();
    }
}
