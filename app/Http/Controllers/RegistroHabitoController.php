<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\RegistroHabito;
use App\Services\EstimadorConsumo;
use App\Services\ViviendasDelUsuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class RegistroHabitoController extends Controller
{
    public function create(Request $request, ViviendasDelUsuario $viviendasDelUsuario): View|RedirectResponse
    {
        $vivienda = $viviendasDelUsuario->activa($request);

        if (! $vivienda) {
            return redirect()->route('viviendas.create')
                ->with('exito', 'Primero registra una vivienda.');
        }

        $actividades = Actividad::query()->where('activa', true)->orderBy('nombre')->get();

        return view('habitos.crear', compact('vivienda', 'actividades'));
    }

    public function store(
        Request $request,
        ViviendasDelUsuario $viviendasDelUsuario,
        EstimadorConsumo $estimador
    ): RedirectResponse {
        $vivienda = $viviendasDelUsuario->activa($request);

        if (! $vivienda) {
            return redirect()->route('viviendas.create');
        }

        $datos = $request->validate([
            'actividad_id' => ['required', 'integer', Rule::exists('actividades', 'id')->where('activa', true)],
            'cantidad' => ['required', 'numeric', 'min:0.01', 'max:1000'],
            'fecha' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
        ]);

        $actividad = Actividad::findOrFail($datos['actividad_id']);
        $estimacion = $estimador->estimar($actividad, (float) $datos['cantidad']);

        RegistroHabito::create([
            'user_id' => $request->user()->id,
            'vivienda_id' => $vivienda->id,
            'actividad_id' => $actividad->id,
            'fecha' => $datos['fecha'],
            'cantidad' => $datos['cantidad'],
            ...$estimacion,
        ]);

        return redirect()->route('dashboard')->with(
            'exito',
            'Hábito registrado: '.number_format($estimacion['litros_consumidos'], 2).' litros estimados.'
        );
    }
}
