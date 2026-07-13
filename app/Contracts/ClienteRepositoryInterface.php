<?php

namespace App\Contracts;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClienteRepositoryInterface
{
    public function getAll(): Collection;
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    public function findById(int $id): ?Cliente;
    public function create(array $data): Cliente;
    public function update(Cliente $cliente, array $data): bool;
    public function delete(Cliente $cliente): bool;
}
