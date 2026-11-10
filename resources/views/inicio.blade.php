@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')
<section class="overflow-hidden rounded-[28px] bg-[#1F5F5B] px-7 py-14 text-white shadow-xl md:px-14 md:py-20">
    <div class="max-w-3xl">
        <p class="mb-5 inline-flex rounded-full border border-white/30 px-4 py-2 text-xs font-bold uppercase tracking-widest text-emerald-100">Consumo responsable de agua</p>
        <h1 class="mb-6 text-4xl font-extrabold leading-tight tracking-tight md:text-6xl">Cada gota cuenta. <span class="text-[#b2e4aa]">Empieza por conocer tus hábitos.</span></h1>
        <p class="mb-9 max-w-2xl text-lg leading-8 text-emerald-50">Registra tus actividades cotidianas, conoce cuántos litros utilizas aproximadamente y observa el progreso de tu vivienda.</p>
        <div class="flex flex-wrap gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-xl bg-white px-6 py-3 font-bold text-[#1F5F5B] hover:bg-emerald-50">Ir a mi dashboard</a>
            @else
                <a href="{{ route('register') }}" class="rounded-xl bg-white px-6 py-3 font-bold text-[#1F5F5B] hover:bg-emerald-50">Comenzar gratis</a>
                <a href="{{ route('login') }}" class="rounded-xl border border-white/40 px-6 py-3 font-bold hover:bg-white/10">Ya tengo cuenta</a>
            @endauth
        </div>
    </div>
</section>
<div class="mt-8 grid gap-5 md:grid-cols-3">
    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#e1e9e3]">
        <div class="mb-4 grid size-12 place-items-center rounded-2xl bg-blue-50 text-2xl text-[#2B8BC6]">01</div>
        <h2 class="mb-2 text-lg font-bold text-[#1F5F5B]">Registra una vivienda</h2>
        <p class="text-sm leading-6 text-slate-600">Agrupa los hábitos de consumo según la vivienda a la que pertenecen.</p>
    </article>
    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#e1e9e3]">
        <div class="mb-4 grid size-12 place-items-center rounded-2xl bg-emerald-50 text-2xl text-[#2E7D6B]">02</div>
        <h2 class="mb-2 text-lg font-bold text-[#1F5F5B]">Anota tus hábitos</h2>
        <p class="text-sm leading-6 text-slate-600">Indica cuánto duró tu ducha y obtén una estimación de litros utilizados.</p>
    </article>
    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#e1e9e3]">
        <div class="mb-4 grid size-12 place-items-center rounded-2xl bg-amber-50 text-2xl text-[#C9A227]">03</div>
        <h2 class="mb-2 text-lg font-bold text-[#1F5F5B]">Consulta resultados</h2>
        <p class="text-sm leading-6 text-slate-600">Visualiza tus últimos registros y el total estimado de la semana.</p>
    </article>
</div>
@endsection
