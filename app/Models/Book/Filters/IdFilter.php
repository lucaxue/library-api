<?php

namespace App\Models\Book\Filters;

use Illuminate\Database\Eloquent\Builder;

class IdFilter implements Filter
{
    /** @var string[] */
    private readonly array $ids;

    public function __construct(string ...$ids)
    {
        $this->ids = $ids;
    }

    public function applyToQuery(Builder $query) : Builder
    {
        return $query->whereKey($this->ids);
    }
}
