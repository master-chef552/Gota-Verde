@extends('layouts.app')

@section('titulo', 'Crear cuenta')

@section('contenido')
<section class="mx-auto max-w-lg rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#dfe8e1] md:p-10">
    <p class="mb-2 text-xs font-bold uppercase tracking-widest text-[#2E7D6B]">Comienza aquí</p>
    <h1 class="mb-2 text-3xl font-extrabold text-[#1F5F5B]">Crear cuenta</h1>
    <p class="mb-8 text-sm text-slate-600">Usaremos tu cuenta para vincular tus viviendas y hábitos.</p>
    <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
        @csrf
        <div>
            <label for="name" class="mb-2 block text-sm font-semibold">Nombre</label>
            <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" required maxlength="120" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-[#2E7D6B] focus:ring-2 focus:ring-emerald-100">
            @error('name') <p class="mt-1 text-xs text-rose-700">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="email" class="mb-2 block text-sm font-semibold">Correo electrónico</label>
            <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-[#2E7D6B] focus:ring-2 focus:ring-emerald-100">
            @error('email') <p class="mt-1 text-xs text-rose-700">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password" class="mb-2 block text-sm font-semibold">Contraseña</label>
            <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" required class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-[#2E7D6B] focus:ring-2 focus:ring-emerald-100">
            <p class="mt-1 text-xs text-slate-500">Mínimo 8 caracteres.</p>
            @error('password') <p class="mt-1 text-xs text-rose-700">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password_confirmation" class="mb-2 block text-sm font-semibold">Confirmar contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" required class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-[#2E7D6B] focus:ring-2 focus:ring-emerald-100">
        </div>
        <button type="submit" class="w-full rounded-xl bg-[#2E7D6B] px-5 py-3 font-bold text-white hover:bg-[#1F5F5B]">Crear cuenta</button>
    </form>
    <p class="mt-7 text-center text-sm text-slate-600">¿Ya tienes cuenta? <a class="font-bold text-[#1F5F5B] underline" href="{{ route('login') }}">Inicia sesión</a></p>
</section>
@endsection
