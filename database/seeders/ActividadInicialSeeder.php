<?php

namespace Database\Seeders;

use App\Models\Actividad;
use Illuminate\Database\Seeder;

class ActividadInicialSeeder extends Seeder
{
    public function run(): void
    {
        Actividad::firstOrCreate(
            ['clave' => 'ducha'],
            [
                'nombre' => 'Ducha',
                'unidad' => 'minuto',
                'litros_por_unidad' => 10,
                // Valor de demostración, no estándar científico: ajustar después.
                'referencia_eficiente' => 5,
                'activa' => true,
            ]
        );
    }
}
