<?php

namespace App\Models\Book;

use App\Models\Book\Filters\Filter;
use App\Models\Book\Filters\Filters;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookFinder
{
    public function all(
        Filter $filters = new Filters(),
        int $perPage = 50,
    ) : LengthAwarePaginator {

        $query = Book::query();

        $query = $filters->applyToQuery($query);

        return $query->paginate($perPage);
    }
}
