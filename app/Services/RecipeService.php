<?php

namespace App\Services;

use App\Models\Recipe;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RecipeService
{
    public function recipesForIndex()
    {
        return QueryBuilder::for(Recipe::class)
            ->allowedFilters([
                AllowedFilter::exact('email', 'authors_email'),
                AllowedFilter::scope('keyword', 'whereKeyword'),
                AllowedFilter::scope('ingredient', 'whereHasIngredient'),
            ])
            ->jsonPaginate()
            ->setPath(route('recipes.index', [], false));
    }
}
