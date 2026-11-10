<?php

use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\Auth\SesionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistroHabitoController;
use App\Http\Controllers\ViviendaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'inicio')->name('inicio');

Route::middleware('guest')->group(function (): void {
    Route::get('/registro', [RegistroController::class, 'create'])->name('register');
    Route::post('/registro', [RegistroController::class, 'store'])->middleware('throttle:5,1')->name('register.store');
    Route::get('/ingresar', [SesionController::class, 'create'])->name('login');
    Route::post('/ingresar', [SesionController::class, 'store'])->middleware('throttle:6,1')->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/salir', [SesionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/viviendas/crear', [ViviendaController::class, 'create'])->name('viviendas.create');
    Route::post('/viviendas', [ViviendaController::class, 'store'])->name('viviendas.store');
    Route::post('/viviendas/{vivienda}/seleccionar', [ViviendaController::class, 'seleccionar'])->name('viviendas.seleccionar');
    Route::get('/habitos/crear', [RegistroHabitoController::class, 'create'])->name('habitos.create');
    Route::post('/habitos', [RegistroHabitoController::class, 'store'])->name('habitos.store');
});
