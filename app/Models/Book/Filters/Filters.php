<?php

namespace App\Models\Book\Filters;

use Illuminate\Database\Eloquent\Builder;

class Filters implements Filter
{
    /** @var Filter[] */
    private readonly array $filters;

    public function __construct(Filter ...$filters)
    {
        $this->filters = $filters;
    }

    public function applyToQuery(Builder $query) : Builder
    {
        foreach ($this->filters as $filter) {
            $filter->applyToQuery($query);
        }

        return $query;
    }
}
