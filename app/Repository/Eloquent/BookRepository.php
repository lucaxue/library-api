<?php

namespace App\Repository\Eloquent;

use App\Models\Book;
use App\Repository\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    protected Model $model;

    public function __construct(Book $book)
    {
        $this->model = $book;
    }
}
