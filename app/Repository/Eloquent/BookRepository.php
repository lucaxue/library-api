<?php

namespace App\Repository\Eloquent;

use App\Models\Book;
use App\Repository\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
  /**
   * @var Illuminate\Database\Eloquent\Model
   */
  protected Model $model;

  /**
   * UserRepository constructor
   * 
   * @param User $model
   */
  public function __construct(Book $model)
  {
    $this->model = $model;
  }
}
