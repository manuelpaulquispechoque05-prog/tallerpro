<?php

namespace App\Services;

use App\Models\CategoriaRepuesto;
use App\Models\Proveedor;
use App\Models\Repuesto;

class RepuestoService
{
    public function __construct(
        protected ConfiguracionService $configuracionService
    ) {}

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

    public function listar(string $busqueda = null, array $filtros = [])
    {
        $desde = $filtros['desde'] ?? null;
        $hasta = $filtros['hasta'] ?? null;
        $mes = $filtros['mes'] ?? null;
        $anio = $filtros['anio'] ?? null;

        return Repuesto::with(['categoria', 'proveedor', 'inventario'])
            ->when($busqueda, fn($q) => $q->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('codigo', 'like', "%{$busqueda}%")
                  ->orWhereHas('proveedor', fn($p) => $p->where('nombre', 'like', "%{$busqueda}%"));
            }))
            ->when($desde, fn($q) => $q->whereDate('created_at', '>=', $desde))
            ->when($hasta, fn($q) => $q->whereDate('created_at', '<=', $hasta))
            ->when($mes, fn($q) => $q->whereMonth('created_at', $mes))
            ->when($anio, fn($q) => $q->whereYear('created_at', $anio))
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
        $moneda = $data['moneda_compra'] ?? 'Bs';
        $precioOriginal = $data['precio_compra_original'] ?? $data['precio_compra'];
        $conversion = $this->configuracionService->convertirABs($precioOriginal, $moneda);

        return Repuesto::create([
            'categoria_id' => $data['categoria_id'] ?? null,
            'proveedor_id' => $data['proveedor_id'],
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'precio_compra' => $conversion['monto_bs'],
            'precio_venta' => $data['precio_venta'],
            'unidad_medida' => $data['unidad_medida'] ?? 'unidad',
            'activo' => true,
            'precio_compra_original' => $conversion['monto_original'],
            'moneda_compra' => $conversion['moneda'],
            'tipo_cambio_compra' => $conversion['tipo_cambio'],
        ]);
    }

    public function actualizar(int $id, array $data): Repuesto
    {
        $repuesto = Repuesto::findOrFail($id);

        $moneda = $data['moneda_compra'] ?? $repuesto->moneda_compra ?? 'Bs';
        $precioOriginal = $data['precio_compra_original'] ?? $data['precio_compra'] ?? $repuesto->precio_compra;
        $conversion = $this->configuracionService->convertirABs($precioOriginal, $moneda);

        $repuesto->update([
            'categoria_id' => $data['categoria_id'] ?? $repuesto->categoria_id,
            'proveedor_id' => $data['proveedor_id'],
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? $repuesto->descripcion,
            'precio_compra' => $conversion['monto_bs'],
            'precio_venta' => $data['precio_venta'],
            'unidad_medida' => $data['unidad_medida'] ?? $repuesto->unidad_medida,
            'precio_compra_original' => $conversion['monto_original'],
            'moneda_compra' => $conversion['moneda'],
            'tipo_cambio_compra' => $conversion['tipo_cambio'],
        ]);
        return $repuesto;
    }

    public function eliminar(int $id): void
    {
        Repuesto::findOrFail($id)->delete();
    }
}
