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
        $recipes = Recipe::factory(2)->create([
            'name' => 'Test Recipe',
        ]);

        $this->assertNotEquals($recipes[0]->slug, $recipes[1]->slug);
        $this->assertEquals('test-recipe-1', $recipes[1]->slug);
    }

    public function test_index_page()
    {
        $names = [
            'Page 1 Recipe 1',
            'Page 1 Recipe 2',
            'Page 2 Recipe 1',
            'Page 1 Recipe 2',
        ];
        collect($names)->each(function ($name) {
            Recipe::factory()->create(['name' => $name]);
        });

        $response = $this->get('/api/recipes');
        $response->assertStatus(200);
        $response->assertSee($names[0]);
        $response->assertSee($names[1]);

        $response = $this->get('/api/recipes?page[size]=2&page[number]=2');
        $response->assertStatus(200);
        $response->assertSee($names[2]);
        $response->assertSee($names[3]);
    }

    public function test_show_page()
    {
        $recipe = Recipe::factory()->create(['name' => 'Test Recipe']);

        $response = $this->get("/api/recipes/test-recipe");

        $response->assertStatus(200);
        $response->assertSee($recipe->name);
    }

    public function test_exact_email_filter()
    {
        Recipe::factory(2)->create(['authors_email' => 'some@email.com']);

        $response = $this->get("/api/recipes?filter[email]=some@email.com");
        $response->assertStatus(200);
        $response->assertSee('some@email.com');
        $response->assertJson(['meta' => ['total' => 2]]);

        $response = $this->get("/api/recipes?filter[email]=some@email");
        $response->assertStatus(200);
        $response->assertJson(['meta' => ['total' => 0]]);
    }

    public function test_keyword_filter()
    {
        $keyword = 'scallop';

        Recipe::factory(2)->create();
        Recipe::factory()->create(['name' => "Scallop Pasta"]);
        Recipe::factory()->create(['description' => "Delicious scallops in a creamy sauce"]);
        Recipe::factory()->hasIngredients(1, ['name' => 'Raw scallops'])->hasIngredients(2)->create();
        Recipe::factory()->hasSteps(1, ['description' => 'Throw the scallops away'])->hasSteps(3)->create();

        $response = $this->get("/api/recipes?filter[keyword]={$keyword}");
        $response->assertStatus(200);
        $response->assertJson(['meta' => ['total' => 4]]);
    }

    public function test_ingredient_filter()
    {
        $ingredient = 'potato';

        Recipe::factory(5)->hasIngredients(3)->create();
        $recipe = Recipe::factory()->hasIngredients(1, ['name' => '3 large potatoes'])->hasIngredients(2)->create();

        $response = $this->get("/api/recipes?filter[ingredient]={$ingredient}");
        $response->assertStatus(200);
        $response->assertSee($recipe->name);
        $response->assertJson(['meta' => ['total' => 1]]);
    }

    public function test_combined_filter()
    {
        $email = 'foo@bar.com';
        $ingredient = 'potato';
        $keyword = 'scallop';
        $url = "/api/recipes?filter[ingredient]={$ingredient}&filter[keyword]={$keyword}&filter[email]={$email}";

        Recipe::factory(2)->create();

        $response = $this->get($url);
        $response->assertStatus(200);
        $response->assertJson(['meta' => ['total' => 0]]);

        Recipe::factory()
            ->hasIngredients(1, ['name' => '3 large potatoes'])
            ->hasIngredients(2)
            ->hasSteps(3)
            ->create(['authors_email' => $email]);

        $response = $this->get($url);
        $response->assertStatus(200);
        $response->assertJson(['meta' => ['total' => 0]]);

        Recipe::factory()
            ->hasIngredients(1, ['name' => '3 large potatoes'])
            ->hasIngredients(2)
            ->hasSteps(1, ['description' => 'Throw the scallops away'])
            ->hasSteps(3)
            ->create(['authors_email' => $email]);

        $response = $this->get($url);
        $response->assertStatus(200);
        $response->assertJson(['meta' => ['total' => 1]]);
    }
}
