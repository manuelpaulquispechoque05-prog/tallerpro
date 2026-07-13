<?php

namespace App\Repositories;

use App\Contracts\ClienteRepositoryInterface;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ClienteRepository implements ClienteRepositoryInterface
{
    public function getAll(): Collection
    {
        return Cliente::all();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Cliente::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): ?Cliente
    {
        return Cliente::find($id);
    }

    public function create(array $data): Cliente
    {
        return Cliente::create($data);
    }

    public function update(Cliente $cliente, array $data): bool
    {
        return $cliente->update($data);
    }

    public function delete(Cliente $cliente): bool
    {
        return $cliente->delete();
    }
}
