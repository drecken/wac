<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Step extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    public function buildSortQuery()
    {
        return static::query()->where('recipe_id', $this->recipe_id);
    }
}
