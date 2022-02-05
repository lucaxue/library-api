<?php

namespace App\Models\Book\Filters;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    public function applyToQuery(Builder $query) : Builder;
}
