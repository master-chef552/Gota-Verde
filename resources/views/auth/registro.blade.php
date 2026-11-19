@extends('layouts.auth')
@section('titulo','Crear cuenta')
@section('contenido')
<h1>Crear cuenta</h1><p class="gv-sub">Comienza a registrar tus hábitos de consumo.</p><form method="POST" action="{{ route('register.store') }}">@csrf
<div class="gv-field"><label for="name">Nombre</label><input id="name" name="name" autocomplete="name" maxlength="120" required value="{{ old('name') }}"></div>
<div class="gv-field"><label for="email">Correo electrónico</label><input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"></div>
<div class="gv-field"><label for="password">Contraseña</label><input id="password" name="password" type="password" autocomplete="new-password" minlength="8" required><small class="gv-note">Mínimo 8 caracteres.</small></div>
<div class="gv-field"><label for="password_confirmation">Confirmar contraseña</label><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" required></div><button class="gv-btn">Crear cuenta</button></form><p class="gv-auth-bottom">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
@endsection
