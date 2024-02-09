<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $methodName = Arr::random(['dairyName', 'vegetableName', 'fruitName', 'meatName', 'sauceName']);
        $ingredient = $this->faker->{$methodName}();

        return [
            'name' => $ingredient = $ingredient === 'Potato' ? 'Ziemniak' : $ingredient,
        ];
    }
}
