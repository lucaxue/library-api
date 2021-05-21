<?php

namespace App\Repository\Eloquent;

use App\Repository\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements EloquentRepositoryInterface
{
  /**
   * @var Model
   */
  protected Model $model;

  /**
   * BaseRepository Contructor
   * @param Model $model
   */
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function all(): Collection
  {
    return $this->model->paginate(15);
  }

  public function search(string $query): Collection
  {
    $columns = $this->model->getFillable();
    $model = $this->model;

    foreach ($columns as $column) {
      $model->where($column, 'ilike', "%$query%");
    }

    return $model->paginate(15);
  }

  public function findById(int $id): ?Model
  {
    return $this->model->find($id);
  }

  public function create(array $payload): Model
  {
    return $this->model->create($payload);
  }

  public function update(array $payload, int $id): Model
  {
    $model = $this->model->find($id);
    $model->update($payload);

    return $model;
  }

  public function deleteById(int $id): bool
  {
    return $this->model->destroy($id);
  }
}
