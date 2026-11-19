<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>@yield('titulo','GotaVerde') | GotaVerde</title>@vite(['resources/css/app.css','resources/js/app.js'])<link rel="stylesheet" href="{{ asset('css/gotaverde.css') }}"></head><body>
<div class="gv-shell"><aside class="gv-nav">@include('partials.brand')<nav aria-label="Navegación principal">
<a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
<a class="{{ request()->routeIs('habitos.*') ? 'active' : '' }}" href="{{ route('habitos.create') }}">Registrar hábito</a>
<a class="{{ request()->routeIs('lecturas') ? 'active' : '' }}" href="{{ route('lecturas') }}">Lecturas</a>
<a class="{{ request()->routeIs('metas') ? 'active' : '' }}" href="{{ route('metas') }}">Metas</a>
<a class="{{ request()->routeIs('logros') ? 'active' : '' }}" href="{{ route('logros') }}">Logros y rachas</a>
<a class="{{ request()->routeIs('viviendas.*') ? 'active' : '' }}" href="{{ route('viviendas.index') }}">Mis viviendas</a>
</nav><footer>{{ auth()->user()->name }}<form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Cerrar sesión</button></form></footer></aside><main class="gv-main">@include('partials.alerts')@yield('contenido')</main></div></body></html>
