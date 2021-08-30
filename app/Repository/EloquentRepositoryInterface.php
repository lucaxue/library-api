<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * Gets all models.
     *
     * @return Illuminate\Database\Eloquent\Collection|array;
     */
    public function all(): Collection|array;

    /**
     * Gets all models with query.
     *
     * @param string $search
     * @return Illuminate\Database\Eloquent\Collection|array;
     */
    public function search(string $search): Collection|array;

    /**
     * Find model by id.
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model|null;
     */
    public function findById(int $id): ?Model;

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Illuminate\Database\Eloquent\Model;
     */
    public function create(array $payload): Model;

    /**
     * Update an existing model.
     *
     * @param array $payload
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model;
     */
    public function update(array $payload, int $id): Model;

    /**
     * Delete model by id.
     *
     * @param int $id
     * @return bool;
     */
    public function deleteById(int $id): bool;
}
