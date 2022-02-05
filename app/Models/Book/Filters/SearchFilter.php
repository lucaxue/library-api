<?php

namespace App\Models\Book\Filters;

use Illuminate\Database\Eloquent\Builder;

class SearchFilter implements Filter
{
    public function __construct(
        private readonly string $searchTerm,
    ) {}

    public function applyToQuery(Builder $query) : Builder
    {
        return $query->where(function ($query) {
            $query
                ->where('title', 'LIKE', '%'.$this->searchTerm.'%')
                ->orWhere('author', 'LIKE', '%'.$this->searchTerm.'%');
        });
    }
}
