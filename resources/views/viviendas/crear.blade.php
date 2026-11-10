@extends('layouts.app')

@section('titulo', 'Registrar vivienda')

@section('contenido')
<div class="mx-auto max-w-2xl">
    <a href="{{ route('dashboard') }}" class="mb-5 inline-flex text-sm font-semibold text-[#2E7D6B] hover:underline">← Volver al dashboard</a>
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#dfe8e1] md:p-10">
        <p class="mb-2 text-xs font-bold uppercase tracking-widest text-[#2E7D6B]">Configuración inicial</p>
        <h1 class="mb-2 text-3xl font-extrabold text-[#1F5F5B]">Registrar vivienda</h1>
        <p class="mb-8 text-sm leading-6 text-slate-600">Estos datos identifican tu vivienda. Solo las personas autorizadas podrán consultar sus registros.</p>
        <form method="POST" action="{{ route('viviendas.store') }}" class="grid gap-5 sm:grid-cols-2">
            @csrf
            <div class="sm:col-span-2">
                <label for="alias" class="mb-2 block text-sm font-semibold">Nombre o alias</label>
                <input id="alias" name="alias" type="text" required maxlength="100" placeholder="Ejemplo: Casa principal" value="{{ old('alias') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#2E7D6B] focus:outline-none">
                @error('alias') <p class="mt-1 text-xs text-rose-700">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="tipo" class="mb-2 block text-sm font-semibold">Tipo de vivienda</label>
                <select id="tipo" name="tipo" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 focus:border-[#2E7D6B] focus:outline-none">
                    <option value="">Seleccionar</option>
                    <option value="Casa" @selected(old('tipo') === 'Casa')>Casa</option>
                    <option value="Departamento" @selected(old('tipo') === 'Departamento')>Departamento</option>
                    <option value="Otro" @selected(old('tipo') === 'Otro')>Otro</option>
                </select>
            </div>
            <div>
                <label for="habitantes" class="mb-2 block text-sm font-semibold">Número de habitantes</label>
                <input id="habitantes" name="habitantes" type="number" min="1" max="30" required value="{{ old('habitantes', 1) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#2E7D6B] focus:outline-none">
            </div>
            <div>
                <label for="alcaldia" class="mb-2 block text-sm font-semibold">Alcaldía o municipio</label>
                <input id="alcaldia" name="alcaldia" type="text" required maxlength="100" value="{{ old('alcaldia') }}" placeholder="Ejemplo: Iztapalapa" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#2E7D6B] focus:outline-none">
            </div>
            <div>
                <label for="codigo_postal" class="mb-2 block text-sm font-semibold">Código postal</label>
                <input id="codigo_postal" name="codigo_postal" type="text" inputmode="numeric" pattern="[0-9]{5}" minlength="5" maxlength="5" required value="{{ old('codigo_postal') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#2E7D6B] focus:outline-none">
            </div>
            <div class="sm:col-span-2">
                <label for="tarifa_m3" class="mb-2 block text-sm font-semibold">Tarifa por m³ en pesos (opcional)</label>
                <input id="tarifa_m3" name="tarifa_m3" type="number" min="0" max="10000" step="0.01" value="{{ old('tarifa_m3') }}" placeholder="Ejemplo: 20.00" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#2E7D6B] focus:outline-none">
                <p class="mt-2 text-xs leading-5 text-slate-500">Si desconoces la tarifa, deja el campo vacío. Por ahora no se calculará ahorro económico; los resultados monetarios serán orientativos.</p>
            </div>
            <div class="sm:col-span-2">
                <button type="submit" class="w-full rounded-xl bg-[#2E7D6B] px-5 py-3 font-bold text-white hover:bg-[#1F5F5B]">Guardar vivienda</button>
            </div>
        </form>
    </section>
</div>
@endsection
