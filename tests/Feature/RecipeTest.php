<?php

namespace Tests\Feature;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_slug_is_generated_from_name(): void
    {
        $recipe = Recipe::factory()->create([
            'name' => 'Test Recipe',
        ]);

        $this->assertEquals('test-recipe', $recipe->slug);
    }

    public function test_if_unique_slug_is_generated_for_the_same_name(): void
    {
        $recipes = Recipe::factory()->count(2)->create([
            'name' => 'Test Recipe',
        ]);

        $this->assertNotEquals($recipes[0]->slug, $recipes[1]->slug);
        $this->assertEquals('test-recipe-1', $recipes[1]->slug);
    }
}
