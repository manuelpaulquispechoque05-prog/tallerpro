<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'marca_id' => 'required|exists:marcas_vehiculo,id',
            'modelo_id' => 'required|exists:modelos_vehiculo,id',
            'anio' => 'required|integer|min:1990|max:2030',
            'placa' => 'required|string|max:15|unique:vehiculos,placa',
            'vin' => 'nullable|string|max:17|unique:vehiculos,vin',
            'color' => 'nullable|string|max:30',
            'kilometraje' => 'nullable|integer|min:0',
        ];
    }
}
