@extends('layouts.auth')
@section('titulo','Iniciar sesión')
@section('contenido')
<h1>Iniciar sesión</h1><p class="gv-sub">Bienvenido de nuevo. Ingresa tus datos.</p>
<form method="POST" action="{{ route('login.store') }}">@csrf
<div class="gv-field"><label for="email">Correo electrónico</label><input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"></div>
<div class="gv-field"><label for="password">Contraseña</label><input id="password" name="password" type="password" autocomplete="current-password" required></div>
<div class="gv-auth-links"><label><input type="checkbox" name="remember" value="1" @checked(old('remember'))> Recordarme</label><span class="gv-disabled" title="Próximamente">¿Olvidaste tu contraseña? (pendiente)</span></div>
<button class="gv-btn" type="submit">Entrar</button></form><p class="gv-auth-bottom">¿No tienes cuenta? <a href="{{ route('register') }}"><strong>Regístrate</strong></a></p>
@endsection
