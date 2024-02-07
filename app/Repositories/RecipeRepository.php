<?php

namespace App\Repositories;

use App\Models\Recipe;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RecipeRepository
{
    public function filteredPaginatedRecipes(): LengthAwarePaginator
    {
        return QueryBuilder::for(Recipe::class)
            ->allowedFilters([
                AllowedFilter::exact('email', 'authors_email'),
                AllowedFilter::scope('keyword', 'whereKeyword'),
                AllowedFilter::scope('ingredient', 'whereHasIngredient'),
            ])
            ->jsonPaginate();
    }
}
