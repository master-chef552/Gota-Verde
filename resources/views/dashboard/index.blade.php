@extends('layouts.app')

@section('titulo', 'Mi dashboard')

@section('contenido')
<section class="mb-7 flex flex-wrap items-start justify-between gap-4">
    <div>
        <p class="mb-1 text-sm font-semibold text-[#2E7D6B]">Panel personal</p>
        <h1 class="text-3xl font-extrabold tracking-tight text-[#1F5F5B] md:text-4xl">Hola, {{ auth()->user()->name }}</h1>
        <p class="mt-2 text-sm text-slate-600">Conoce el consumo estimado de agua en tu hogar.</p>
    </div>
    <a href="{{ route('habitos.create') }}" class="rounded-xl bg-[#2E7D6B] px-5 py-3 text-sm font-bold text-white hover:bg-[#1F5F5B]">+ Registrar hábito</a>
</section>

@if (! $vivienda)
    <section class="rounded-2xl border border-[#dfe8e1] bg-white p-8 text-center shadow-sm md:p-14">
        <div class="mx-auto mb-4 grid size-16 place-items-center rounded-2xl bg-emerald-50 text-3xl text-[#2E7D6B]">⌂</div>
        <h2 class="mb-3 text-2xl font-bold text-[#1F5F5B]">Registra tu primera vivienda</h2>
        <p class="mx-auto mb-7 max-w-md text-sm leading-6 text-slate-600">Para registrar actividades necesitamos saber a qué vivienda corresponden.</p>
        <a href="{{ route('viviendas.create') }}" class="inline-block rounded-xl bg-[#2E7D6B] px-6 py-3 font-bold text-white hover:bg-[#1F5F5B]">Crear vivienda</a>
    </section>
@else
    <section class="mb-7 rounded-2xl border border-[#dfe8e1] bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Vivienda seleccionada</p>
                <h2 class="mt-1 text-xl font-extrabold text-[#1F5F5B]">{{ $vivienda->alias }}</h2>
                <p class="mt-1 text-xs text-slate-500">{{ $vivienda->tipo }} · {{ $vivienda->habitantes }} habitantes · {{ $vivienda->alcaldia }}</p>
            </div>
            <a href="{{ route('viviendas.create') }}" class="text-sm font-bold text-[#2E7D6B] underline">+ Nueva vivienda</a>
        </div>
        @if ($viviendas->count() > 1)
            <div class="mt-5 flex flex-wrap gap-2" aria-label="Elegir vivienda">
                @foreach ($viviendas as $item)
                    <form method="POST" action="{{ route('viviendas.seleccionar', $item) }}">
                        @csrf
                        <button type="submit" aria-pressed="{{ $item->id === $vivienda->id ? 'true' : 'false' }}" class="rounded-xl border px-4 py-2 text-sm font-semibold {{ $item->id === $vivienda->id ? 'border-[#2E7D6B] bg-emerald-50 text-[#1F5F5B]' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">{{ $item->alias }}</button>
                    </form>
                @endforeach
            </div>
        @endif
    </section>

    <div class="mb-7 grid gap-4 md:grid-cols-4">
        <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#dfe8e1]">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-slate-500">Litros esta semana</p>
            <p class="text-3xl font-extrabold text-[#2B8BC6]">{{ number_format($litrosSemana, 2) }} <span class="text-lg">L</span></p>
            <p class="mt-3 text-xs text-slate-500">Consumo registrado estimado</p>
        </article>
        <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#dfe8e1]">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-slate-500">Ahorro estimado</p>
            <p class="text-3xl font-extrabold text-[#5FA35A]">{{ number_format($ahorradosSemana, 2) }} <span class="text-lg">L</span></p>
            <p class="mt-3 text-xs text-slate-500">Vs. referencia de cada actividad</p>
        </article>
        <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#dfe8e1]">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-slate-500">Ahorro teórico</p>
            <p class="text-3xl font-extrabold text-[#1F5F5B]">${{ number_format($pesosSemana, 2) }}</p>
            <p class="mt-3 text-xs text-slate-500">{{ (float) $vivienda->tarifa_m3 > 0 ? 'Basado en tarifa por m³' : 'Sin tarifa configurada' }}</p>
        </article>
        <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#dfe8e1]">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-slate-500">Registros esta semana</p>
            <p class="text-3xl font-extrabold text-[#C9A227]">{{ $actividadesSemana }}</p>
            <p class="mt-3 text-xs text-slate-500">Actividades registradas</p>
        </article>
    </div>

    <section class="overflow-hidden rounded-2xl border border-[#dfe8e1] bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 px-6 py-5">
            <div>
                <h2 class="text-xl font-extrabold text-[#1F5F5B]">Últimos hábitos registrados</h2>
                <p class="mt-1 text-xs text-slate-500">Solo se muestran registros de la vivienda seleccionada.</p>
            </div>
            <a href="{{ route('habitos.create') }}" class="text-sm font-bold text-[#2E7D6B] underline">Añadir actividad</a>
        </div>
        @if ($registros->isEmpty())
            <div class="p-9 text-center">
                <p class="mb-4 text-sm text-slate-600">Todavía no hay actividades registradas.</p>
                <a href="{{ route('habitos.create') }}" class="inline-block rounded-xl bg-[#2E7D6B] px-5 py-3 text-sm font-bold text-white">Registrar primera ducha</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-[#F4F7F5] text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-4">Fecha</th>
                            <th scope="col" class="px-6 py-4">Actividad</th>
                            <th scope="col" class="px-6 py-4">Cantidad</th>
                            <th scope="col" class="px-6 py-4">Consumo est.</th>
                            <th scope="col" class="px-6 py-4">Ahorro est.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($registros as $registro)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4">{{ $registro->fecha->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 font-semibold">{{ $registro->actividad->nombre }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ number_format((float) $registro->cantidad, 2) }} {{ $registro->actividad->unidad }}(s)</td>
                                <td class="whitespace-nowrap px-6 py-4 font-bold text-[#2B8BC6]">{{ number_format((float) $registro->litros_consumidos, 2) }} L</td>
                                <td class="whitespace-nowrap px-6 py-4 font-bold text-[#2E7D6B]">{{ number_format((float) $registro->litros_ahorrados, 2) }} L</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
    <p class="mt-5 text-xs leading-5 text-slate-500">* El cálculo es orientativo. No representa una lectura de medidor ni prueba un ahorro económico real. La referencia de eficiencia inicial es provisional.</p>
@endif
@endsection
