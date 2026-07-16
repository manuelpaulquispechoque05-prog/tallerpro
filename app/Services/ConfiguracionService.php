<?php

namespace App\Services;

use App\Models\Configuracion;

class ConfiguracionService
{
    /**
     * Obtiene el valor de una configuracion por su clave.
     */
    public function obtener(string $clave, mixed $default = null): ?string
    {
        return Configuracion::where('clave', $clave)->value('valor') ?? $default;
    }

    /**
     * Actualiza o crea una configuracion.
     */
    public function actualizar(string $clave, string $valor, ?string $descripcion = null): Configuracion
    {
        return Configuracion::updateOrCreate(
            ['clave' => $clave],
            ['valor' => $valor, 'descripcion' => $descripcion ?? $clave]
        );
    }

    /**
     * Obtiene el tipo de cambio actual (USD → Bs).
     */
    public function getTipoCambio(): float
    {
        return (float) ($this->obtener('tipo_cambio_compra', 10.71));
    }

    /**
     * Convierte un monto de Bs a USD usando el tipo de cambio actual.
     */
    public function convertirBsAUsd(float $montoBs): array
    {
        $tc = $this->getTipoCambio();

        return [
            'moneda_origen' => 'Bs',
            'moneda_destino' => 'USD',
            'monto_bs' => $montoBs,
            'tipo_cambio' => $tc,
            'monto_convertido' => round($montoBs / $tc, 2),
        ];
    }

    /**
     * Convierte un monto de USD a Bs usando el tipo de cambio actual
     * o uno proporcionado (para mantener historial).
     */
    public function convertirUsdABs(float $montoUsd, ?float $tipoCambio = null): array
    {
        $tc = $tipoCambio ?? $this->getTipoCambio();

        return [
            'moneda_origen' => 'USD',
            'moneda_destino' => 'Bs',
            'monto_usd' => $montoUsd,
            'tipo_cambio' => $tc,
            'monto_convertido' => round($montoUsd * $tc, 2),
        ];
    }

    /**
     * Convierte un monto a Bs si la moneda no es Bs.
     * Si la moneda es Bs, devuelve el mismo monto sin conversion.
     * Util para metodos que reciben montos en distintas monedas y necesitan
     * almacenar ambos valores.
     */
    public function convertirABs(float $monto, string $moneda, ?float $tipoCambio = null): array
    {
        if (strtoupper($moneda) === 'BS' || strtoupper($moneda) === 'BOB') {
            return [
                'moneda' => 'Bs',
                'monto_original' => $monto,
                'tipo_cambio' => 1,
                'monto_bs' => $monto,
            ];
        }

        $tc = $tipoCambio ?? $this->getTipoCambio();

        return [
            'moneda' => 'USD',
            'monto_original' => $monto,
            'tipo_cambio' => $tc,
            'monto_bs' => round($monto * $tc, 2),
        ];
    }
}
