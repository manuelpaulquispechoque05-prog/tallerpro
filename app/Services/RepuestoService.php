<?php

namespace App\Services;

use App\Models\CategoriaRepuesto;
use App\Models\Proveedor;
use App\Models\Repuesto;

class RepuestoService
{
    // ─── CATEGORIAS ──────────────────────────────────────────────────

    public function listarCategorias()
    {
        return CategoriaRepuesto::orderBy('nombre')->get();
    }

    // ─── PROVEEDORES ─────────────────────────────────────────────────

    public function listarProveedores()
    {
        return Proveedor::where('activo', true)->orderBy('nombre')->get();
    }

    // ─── REPUESTOS ───────────────────────────────────────────────────

    public function listar(string $busqueda = null)
    {
        return Repuesto::with(['categoria', 'proveedor', 'inventario'])
            ->when($busqueda, fn($q) => $q->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('codigo', 'like', "%{$busqueda}%")
                  ->orWhereHas('proveedor', fn($p) => $p->where('nombre', 'like', "%{$busqueda}%"));
            }))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();
    }

    public function obtenerPorId(int $id): Repuesto
    {
        return Repuesto::with(['categoria', 'proveedor', 'inventario'])->findOrFail($id);
    }

    public function crear(array $data): Repuesto
    {
        return Repuesto::create([
            'categoria_id' => $data['categoria_id'] ?? null,
            'proveedor_id' => $data['proveedor_id'],
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'precio_compra' => $data['precio_compra'],
            'precio_venta' => $data['precio_venta'],
            'unidad_medida' => $data['unidad_medida'] ?? 'unidad',
            'activo' => true,
        ]);
    }

    public function actualizar(int $id, array $data): Repuesto
    {
        $repuesto = Repuesto::findOrFail($id);
        $repuesto->update([
            'categoria_id' => $data['categoria_id'] ?? $repuesto->categoria_id,
            'proveedor_id' => $data['proveedor_id'],
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? $repuesto->descripcion,
            'precio_compra' => $data['precio_compra'],
            'precio_venta' => $data['precio_venta'],
            'unidad_medida' => $data['unidad_medida'] ?? $repuesto->unidad_medida,
        ]);
        return $repuesto;
    }

    public function eliminar(int $id): void
    {
        Repuesto::findOrFail($id)->delete();
    }
}
