<?php
namespace App\Http\Controllers;
use App\Models\RegistroHabito;
use App\Services\ViviendasDelUsuario;
use Illuminate\Http\Request;
use Illuminate\View\View;
class DashboardController extends Controller
{
    public function index(Request $request, ViviendasDelUsuario $servicio): View
    {
        $viviendas = $servicio->todas($request);
        $vivienda = $servicio->activa($request, $viviendas);
        $modo = $request->query('modo') === 'global' ? 'global' : 'individual';
        $inicio = now()->startOfWeek(); $fin = $inicio->copy()->addDays(6);
        $dias = collect(range(0,6))->map(fn($i) => $inicio->copy()->addDays($i));
        $registros = collect(); $series = collect(); $litrosSemana = $ahorradosSemana = $pesosSemana = $ahorroAcumulado = 0;
        if ($vivienda) {
            $base = RegistroHabito::query()->where('vivienda_id', $vivienda->id);
            if ($modo === 'individual') $base->where('user_id', $request->user()->id);
            $semana = (clone $base)->whereBetween('fecha',[$inicio->toDateString(), $fin->toDateString()]);
            $litrosSemana = (float)(clone $semana)->sum('litros_consumidos');
            $ahorradosSemana = (float)(clone $semana)->sum('litros_ahorrados');
            $ahorroAcumulado = (float)(clone $base)->sum('litros_ahorrados');
            $pesosSemana = round($ahorradosSemana / 1000 * (float)$vivienda->tarifa_m3,2);
            $series = (clone $semana)->with('actividad')->selectRaw('fecha, actividad_id, SUM(litros_consumidos) AS total')->groupBy('fecha','actividad_id')->get();
            $registros = (clone $base)->with('actividad')->orderByDesc('fecha')->orderByDesc('id')->limit(12)->get();
        }
        $colores = ['#2E7D6B','#2B8BC6','#5FA35A','#C9A227','#E08A5A'];
        $catalogo = $series->pluck('actividad.nombre','actividad_id');
        $paleta = []; foreach($catalogo->keys()->values() as $i => $id) $paleta[$id] = $colores[$i % count($colores)];
        $maximo = max(1, (float)$series->groupBy(fn($r) => $r->fecha->toDateString())->map(fn($g) => $g->sum('total'))->max());
        return view('dashboard.index',compact('viviendas','vivienda','modo','inicio','fin','dias','registros','series','litrosSemana','ahorradosSemana','pesosSemana','ahorroAcumulado','catalogo','paleta','maximo'));
    }
}
