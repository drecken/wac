<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Repositories\RecipeRepository;

class RecipeController extends Controller
{
    public function __construct(protected RecipeRepository $recipeRepository)
    {
    }

    public function index()
    {
        return new RecipeCollection($this->recipeRepository->filteredPaginatedRecipes());
    }

    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe->load('ingredients', 'steps'));
    }

}
