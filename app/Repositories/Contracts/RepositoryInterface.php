<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all(): Collection|array;

    public function search(string $search): Collection|array;

    public function findById(int $id): ?Model;

    public function create(array $payload): Model;

    public function update(array $payload, int $id): Model;

    public function deleteById(int $id): bool;
}
