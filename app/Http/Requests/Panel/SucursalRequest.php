<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class SucursalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('sucursal');

        return [
            'nombre' => 'required|string|max:100|unique:sucursales,nombre,' . $id,
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'ciudad' => 'required|string|max:80',
            'activo' => 'nullable|boolean',
        ];
    }
}
