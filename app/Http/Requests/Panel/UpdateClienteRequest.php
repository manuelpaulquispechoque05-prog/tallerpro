<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clienteId = $this->route('cliente');

        return [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'ci_nit' => ['required', 'string', 'max:20', Rule::unique('clientes', 'ci_nit')->ignore($clienteId)],
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:150',
            'direccion' => 'nullable|string|max:255',
        ];
    }
}
