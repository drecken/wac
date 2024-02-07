<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Recipe extends Model
{
    use HasFactory;
    use HasSlug;

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class)->orderBy('order_column');
    }

    public function scopeWhereKeyword(Builder $query, $keyword): Builder
    {
        return $query->where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->orWhereHas('ingredients', function (Builder $query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->orWhereHas('steps', function (Builder $query) use ($keyword) {
                $query->where('description', 'like', "%{$keyword}%");
            });
    }

    public function scopeWhereHasIngredient(Builder $query, $ingredient): Builder
    {
        return $query->whereHas('ingredients', function (Builder $query) use ($ingredient) {
            $query->where('name', 'like', "%{$ingredient}%");
        });
    }
    
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
