<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Database\Seeder;

class TestRecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // totals:
        // 11 authors_email -
        // 13 potato -
        // 11+1 scallop -
        // 4 authors_email & potato -
        // 3 authors_email & scallop -
        // 6 potato & scallop -
        // 1 authors_email, potato & scallop

        // 1 with authors_email, potato & scallop
        Recipe::factory(['name' => 'One of each', 'authors_email' => 'foo@bar.com'])
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

        // 3 with authors_email & potato
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

        // 5 with potato & scallop
        Recipe::factory(5)
            ->hasIngredients(['name' => '3 large potatoes'])
            ->hasSteps(['description' => 'scallops'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        // 4 with potato
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

        // potato in step
        Recipe::factory()
            ->hasSteps(['description' => '3 large potatoes'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        // email in step
        Recipe::factory()
            ->hasSteps(['description' => 'foo@bar.com'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        // scallop as ingredient
        Recipe::factory()
            ->hasIngredients(['name' => 'scallops'])
            ->hasIngredients(rand(2, 5))
            ->hasSteps(rand(3, 8))
            ->create();

        Recipe::factory([
            'name' => 'Mediterranean Cod en Papillote',
            'description' => 'Mediterranean Cod en Papillote (in parchment) has all the classic flavors of that sunny region with tomatoes, capers, garlic, red onion, olive oil and lemon–all wrapped up in parchment paper parcels! Not only is this a quick and easy meal for the whole family, it\'s a simple and delicious with easy clean up.',
            'authors_email' => 'chef@wildalaskancompany.com'
        ])
            ->has(
                Ingredient::factory(8)->sequence(
                    ['name' => '1pk Cod'],
                    ['name' => '1/2c Tomatoes Halved'],
                    ['name' => '1/4 Red Onion Sliced'],
                    ['name' => '1/2 Lemon Sliced'],
                    ['name' => '1 tbsp Capers'],
                    ['name' => '1 tbsp Garlic'],
                    ['name' => '1 tbsp Olive Oil'],
                    ['name' => '1 tbsp Pepper'],
                )
            )
            ->has(
                Step::factory(3)->sequence(
                    ['description' => 'Ever leave the seafood counter with more questions than answers? Our salmon, combo and white fish plans make sure you never have to be unsure about your seafood again.'],
                    ['description' => 'The heat is on (and we got your back!). Our eco-friendly, insulated cooler and dry ice keep your fish frozen even in the hottest conditions.'],
                    ['description' => 'Our individually wrapped portions are designed for quick and easy cooking. Enjoy stress-free, regular meals and shine at your next dinner (lunch or breakfast) party.'],
                )
            )
            ->create();
    }
}
