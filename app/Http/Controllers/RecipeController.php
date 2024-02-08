<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Services\RecipeService;

class RecipeController extends Controller
{
    public function __construct(protected RecipeService $recipeService)
    {
    }

    public function index()
    {
        return new RecipeCollection($this->recipeService->recipesForIndex());
    }

    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe->load('ingredients', 'steps'));
    }

}
