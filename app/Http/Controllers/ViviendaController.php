<?php

namespace App\Http\Controllers;

use App\Models\Vivienda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ViviendaController extends Controller
{
    public function create(): View
    {
        return view('viviendas.crear');
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'alias' => ['required', 'string', 'max:100'],
            'tipo' => ['required', 'string', 'max:80'],
            'habitantes' => ['required', 'integer', 'min:1', 'max:30'],
            'alcaldia' => ['required', 'string', 'max:100'],
            'codigo_postal' => ['required', 'regex:/^[0-9]{5}$/'],
            'tarifa_m3' => ['nullable', 'numeric', 'min:0', 'max:10000'],
        ]);
        $datos['tarifa_m3'] = $datos['tarifa_m3'] ?? 0;

        $vivienda = DB::transaction(function () use ($datos, $request): Vivienda {
            $nueva = Vivienda::create($datos);
            $nueva->usuarios()->attach($request->user()->id, ['rol' => 'propietario']);

            return $nueva;
        });

        $request->session()->put('vivienda_activa_id', $vivienda->id);

        return redirect()->route('dashboard')
            ->with('exito', 'Vivienda creada correctamente. Ya puedes registrar tus hábitos.');
    }

    public function seleccionar(Request $request, Vivienda $vivienda): RedirectResponse
    {
        // No permitir seleccionar viviendas ajenas aunque se conozca el ID.
        abort_unless($vivienda->usuarios()->whereKey($request->user()->id)->exists(), 404);

        $request->session()->put('vivienda_activa_id', $vivienda->id);

        return redirect()->route('dashboard');
    }
}
