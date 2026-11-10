<?php

namespace App\Http\Controllers;

use App\Models\RegistroHabito;
use App\Services\ViviendasDelUsuario;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request, ViviendasDelUsuario $viviendasDelUsuario): View
    {
        $viviendas = $viviendasDelUsuario->todas($request);
        $vivienda = $viviendasDelUsuario->activa($request, $viviendas);

        $registros = collect();
        $litrosSemana = 0;
        $ahorradosSemana = 0;
        $actividadesSemana = 0;

        if ($vivienda) {
            $consulta = RegistroHabito::query()
                ->where('vivienda_id', $vivienda->id)
                ->whereBetween('fecha', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()]);

            $resumen = (clone $consulta)->selectRaw(
                'COUNT(*) AS total, COALESCE(SUM(litros_consumidos), 0) AS litros, COALESCE(SUM(litros_ahorrados), 0) AS ahorro'
            )->first();

            $litrosSemana = (float) $resumen->litros;
            $ahorradosSemana = (float) $resumen->ahorro;
            $actividadesSemana = (int) $resumen->total;

            $registros = RegistroHabito::query()
                ->with('actividad')
                ->where('vivienda_id', $vivienda->id)
                ->orderByDesc('fecha')
                ->orderByDesc('id')
                ->limit(12)
                ->get();
        }

        $pesosSemana = $vivienda
            ? round($ahorradosSemana / 1000 * (float) $vivienda->tarifa_m3, 2)
            : 0;

        return view('dashboard.index', compact(
            'viviendas', 'vivienda', 'registros', 'litrosSemana',
            'ahorradosSemana', 'actividadesSemana', 'pesosSemana'
        ));
    }
}
