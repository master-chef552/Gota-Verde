@extends('layouts.app')

@section('titulo', 'Registrar hábito')

@section('contenido')
<div class="mx-auto max-w-2xl">
    <a href="{{ route('dashboard') }}" class="mb-5 inline-flex text-sm font-semibold text-[#2E7D6B] hover:underline">← Volver al dashboard</a>
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#dfe8e1] md:p-10">
        <p class="mb-2 text-xs font-bold uppercase tracking-widest text-[#2E7D6B]">Vivienda: {{ $vivienda->alias }}</p>
        <h1 class="mb-2 text-3xl font-extrabold text-[#1F5F5B]">Registrar un hábito</h1>
        <p class="mb-8 text-sm text-slate-600">Para comenzar, registra una ducha e indica su duración en minutos.</p>
        @if ($actividades->isEmpty())
            <div class="rounded-xl bg-amber-50 p-5 text-sm leading-7 text-amber-900">
                No hay actividades disponibles. Ejecuta <code class="rounded bg-amber-100 px-2 py-1">php artisan db:seed --class=ActividadInicialSeeder</code> en la terminal del proyecto.
            </div>
        @else
            <form method="POST" action="{{ route('habitos.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="actividad_id" class="mb-2 block text-sm font-semibold">Actividad</label>
                    <select id="actividad_id" name="actividad_id" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 focus:border-[#2E7D6B] focus:outline-none">
                        <option value="">Selecciona una actividad</option>
                        @foreach ($actividades as $actividad)
                            <option value="{{ $actividad->id }}" data-tasa="{{ $actividad->litros_por_unidad }}" data-referencia="{{ $actividad->referencia_eficiente }}" @selected(old('actividad_id') == $actividad->id)>
                                {{ $actividad->nombre }} ({{ number_format((float) $actividad->litros_por_unidad, 2) }} L/{{ $actividad->unidad }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="cantidad" class="mb-2 block text-sm font-semibold">Cantidad o duración</label>
                    <input id="cantidad" name="cantidad" type="number" min="0.01" max="1000" step="0.01" required placeholder="Ejemplo: 10 minutos" value="{{ old('cantidad') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#2E7D6B] focus:outline-none">
                    <p class="mt-2 text-xs text-slate-500">Para la actividad Ducha, la cantidad se expresa en minutos.</p>
                </div>
                <div id="estimacion-visual" aria-live="polite" class="rounded-xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-[#1F5F5B]">
                    <strong>Vista previa:</strong> <span id="litros-previos">Indica actividad y cantidad para calcular.</span>
                </div>
                <div>
                    <label for="fecha" class="mb-2 block text-sm font-semibold">Fecha de la actividad</label>
                    <input id="fecha" name="fecha" type="date" max="{{ now()->toDateString() }}" required value="{{ old('fecha', now()->toDateString()) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#2E7D6B] focus:outline-none">
                </div>
                <div class="rounded-xl border border-blue-100 bg-blue-50 p-4 text-sm leading-6 text-slate-700">
                    <strong>¿Cómo calculamos los litros?</strong> Para una ducha se utiliza una referencia aproximada de 10 L/min. Por ejemplo, 10 minutos equivalen a 100 litros estimados. El consumo efectivo depende de la regadera y la presión del agua.
                </div>
                <button type="submit" class="w-full rounded-xl bg-[#2E7D6B] px-5 py-3 font-bold text-white hover:bg-[#1F5F5B]">Guardar hábito</button>
            </form>
            <script>
                (() => {
                    const actividad = document.getElementById('actividad_id');
                    const cantidad = document.getElementById('cantidad');
                    const salida = document.getElementById('litros-previos');
                    const mostrar = () => {
                        const opcion = actividad.selectedOptions[0];
                        const tasa = Number(opcion?.dataset.tasa);
                        const valor = Number(cantidad.value);
                        if (!opcion?.value || cantidad.value === '' || !Number.isFinite(valor) || valor <= 0) {
                            salida.textContent = 'Indica actividad y cantidad para calcular.';
                            return;
                        }
                        const litros = valor * tasa;
                        const ahorro = Math.max(0, Number(opcion.dataset.referencia) - valor) * tasa;
                        salida.textContent = `${litros.toFixed(2)} litros estimados · Ahorro estimado frente a la referencia provisional: ${ahorro.toFixed(2)} L.`;
                    };
                    actividad.addEventListener('change', mostrar);
                    cantidad.addEventListener('input', mostrar);
                    mostrar();
                })();
            </script>
        @endif
    </section>
</div>
@endsection
