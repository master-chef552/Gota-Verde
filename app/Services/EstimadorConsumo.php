<?php

namespace App\Services;

use App\Models\Actividad;

class EstimadorConsumo
{
    /**
     * Estimación informativa: NO es una medición real del medidor.
     * @return array{litros_consumidos: float, litros_ahorrados: float}
     */
    public function estimar(Actividad $actividad, float $cantidad): array
    {
        $tasa = (float) $actividad->litros_por_unidad;
        $referencia = (float) $actividad->referencia_eficiente;

        return [
            'litros_consumidos' => round($cantidad * $tasa, 2),
            'litros_ahorrados' => round(max(0, $referencia - $cantidad) * $tasa, 2),
        ];
    }
}
