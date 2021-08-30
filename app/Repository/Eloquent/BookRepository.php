<?php

namespace App\Repository\Eloquent;

use App\Models\Book;
use App\Repository\EloquentRepositoryInterface;

class BookRepository extends Repository implements EloquentRepositoryInterface
{
    public function __construct(Book $book)
    {
        return parent::__construct($book);
    }
}
