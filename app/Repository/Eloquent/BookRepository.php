<?php

namespace App\Repository\Eloquent;

use App\Models\Book;
use App\Repository\BookRepositoryInterface;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $book)
    {
        return parent::__construct($book);
    }
}
