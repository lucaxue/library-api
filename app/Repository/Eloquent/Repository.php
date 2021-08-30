<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements EloquentRepositoryInterface
{
    public function __construct(
        protected Model $model
    ) {
    }

    public function all(): Collection|array
    {
        return $this->model->paginate(15)->all();
    }

    public function search(string $search): Collection|array
    {
        $columns = $this->model->getFillable();

        return $this->model
            ->where(function ($query) use ($columns, $search) {
                foreach ($columns as $field) {
                    $query->orWhere(strtolower($field), 'like', strtolower("%$search%"));
                }
            })
            ->paginate(15)
            ->all();
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
        $model = tap($this->model->find($id))->update($payload);

        return $model->refresh();
    }

    public function deleteById(int $id): bool
    {
        return $this->model->destroy($id);
    }
}
