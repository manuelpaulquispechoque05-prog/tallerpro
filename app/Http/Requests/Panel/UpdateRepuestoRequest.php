<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRepuestoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('repuesto');

        return [
            'categoria_id' => 'nullable|exists:categorias_repuesto,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'codigo' => ['required', 'string', 'max:30', Rule::unique('repuestos', 'codigo')->ignore($id)],
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'unidad_medida' => 'nullable|string|max:20',
            'precio_compra_original' => 'nullable|numeric|min:0',
            'moneda_compra' => 'nullable|in:Bs,USD',
        ];
    }
}
