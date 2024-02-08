<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class TestRecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1 with authors_email, potato & scallop
        Recipe::factory(['authors_email' => 'foo@bar.com'])
            ->hasIngredients(['name' => '3 large potatoes'])
            ->hasSteps(['description' => 'scallops'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        // 2 with authors_email & scallop
        Recipe::factory(2, ['authors_email' => 'foo@bar.com'])
            ->hasSteps(['description' => 'scallops'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        // 3 with authors_email & potatoes
        Recipe::factory(3, ['authors_email' => 'foo@bar.com'])
            ->hasIngredients(['name' => '3 large potatoes'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        // 5 with authors_email
        Recipe::factory(5, ['authors_email' => 'foo@bar.com'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        // 5 with potatoes & scallop
        Recipe::factory(5)
            ->hasIngredients(['name' => '3 large potatoes'])
            ->hasSteps(['description' => 'scallops'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        // 4 with potatoes
        Recipe::factory(4)
            ->hasIngredients(['name' => '3 large potatoes'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        // 3 with scallop
        Recipe::factory(3)
            ->hasSteps(['description' => 'scallops'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        // 20 with random data
        Recipe::factory(20)
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();
    }
}
