<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;

class BookRepository extends BaseRepository
{
    public function __construct(Book $book)
    {
        return parent::__construct($book);
    }
}
