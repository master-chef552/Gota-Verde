@extends('layouts.app')

@section('titulo', 'Ingresar')

@section('contenido')
<section class="mx-auto max-w-lg rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#dfe8e1] md:p-10">
    <p class="mb-2 text-xs font-bold uppercase tracking-widest text-[#2E7D6B]">Bienvenido de nuevo</p>
    <h1 class="mb-2 text-3xl font-extrabold text-[#1F5F5B]">Iniciar sesión</h1>
    <p class="mb-8 text-sm text-slate-600">Accede al panel de tus viviendas.</p>
    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="mb-2 block text-sm font-semibold">Correo electrónico</label>
            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-[#2E7D6B] focus:ring-2 focus:ring-emerald-100">
        </div>
        <div>
            <label for="password" class="mb-2 block text-sm font-semibold">Contraseña</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-[#2E7D6B] focus:ring-2 focus:ring-emerald-100">
        </div>
        <button type="submit" class="w-full rounded-xl bg-[#2E7D6B] px-5 py-3 font-bold text-white hover:bg-[#1F5F5B]">Ingresar</button>
    </form>
    <p class="mt-7 text-center text-sm text-slate-600">¿Todavía no tienes cuenta? <a class="font-bold text-[#1F5F5B] underline" href="{{ route('register') }}">Regístrate</a></p>
    <p class="mt-3 text-center text-xs text-slate-500">La recuperación de contraseña se incorporará en una siguiente etapa.</p>
</section>
@endsection
