<?php

namespace App\Services;

use App\Models\Vivienda;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ViviendasDelUsuario
{
    /** @return Collection<int, Vivienda> */
    public function todas(Request $request): Collection
    {
        return Vivienda::query()
            ->whereHas('usuarios', fn ($consulta) => $consulta->where('users.id', $request->user()->id))
            ->orderBy('alias')
            ->get();
    }

    public function activa(Request $request, ?Collection $viviendas = null): ?Vivienda
    {
        $viviendas ??= $this->todas($request);
        $id = $request->session()->get('vivienda_activa_id');
        $activa = $viviendas->firstWhere('id', (int) $id) ?? $viviendas->first();

        if ($activa) {
            $request->session()->put('vivienda_activa_id', $activa->id);
        } else {
            $request->session()->forget('vivienda_activa_id');
        }

        return $activa;
    }
}
