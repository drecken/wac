<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recipe::factory()
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();
    }
}
