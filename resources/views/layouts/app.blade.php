<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GotaVerde: registra tus hábitos y conoce tu consumo estimado de agua.">
    <title>@yield('titulo', 'GotaVerde') | GotaVerde</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F4F7F5] font-sans text-slate-800 antialiased">
<header class="border-b border-[#dce6df] bg-white/95">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-5 py-4">
        <a href="{{ route('inicio') }}" class="flex items-center gap-3 font-extrabold tracking-tight text-[#1F5F5B]" aria-label="GotaVerde, inicio">
            <span class="grid size-10 place-items-center rounded-xl bg-[#1F5F5B] text-xl text-white" aria-hidden="true">◈</span>
            <span class="text-2xl">Gota<span class="text-[#5FA35A]">Verde</span></span>
        </a>
        <nav aria-label="Navegación principal" class="flex flex-wrap items-center gap-3 text-sm font-semibold">
            @auth
                <a class="rounded-lg px-3 py-2 text-[#1F5F5B] hover:bg-[#F4F7F5]" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="rounded-lg px-3 py-2 text-[#1F5F5B] hover:bg-[#F4F7F5]" href="{{ route('viviendas.create') }}">Nueva vivienda</a>
                <a class="rounded-lg bg-[#2E7D6B] px-4 py-2 text-white hover:bg-[#1F5F5B]" href="{{ route('habitos.create') }}">Registrar hábito</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-lg border border-slate-200 px-3 py-2 hover:bg-slate-50">Salir</button>
                </form>
            @else
                <a class="rounded-lg px-3 py-2 text-[#1F5F5B] hover:bg-[#F4F7F5]" href="{{ route('login') }}">Ingresar</a>
                <a class="rounded-lg bg-[#2E7D6B] px-4 py-2 text-white hover:bg-[#1F5F5B]" href="{{ route('register') }}">Crear cuenta</a>
            @endauth
        </nav>
    </div>
</header>
<main class="mx-auto max-w-6xl px-5 py-9">
    @if (session('exito'))
        <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-900">
            {{ session('exito') }}
        </div>
    @endif
    @if ($errors->any())
        <div role="alert" class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-900">
            Revisa los datos del formulario. {{ $errors->first() }}
        </div>
    @endif
    @yield('contenido')
</main>
<footer class="mt-10 border-t border-[#dce6df] py-7 text-center text-xs text-slate-500">
    GotaVerde · Proyecto académico en desarrollo · Los litros mostrados son estimaciones, no mediciones reales.
</footer>
</body>
</html>
