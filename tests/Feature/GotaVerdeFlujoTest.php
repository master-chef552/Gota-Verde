<?php

use App\Models\Actividad;
use App\Models\User;
use App\Models\Vivienda;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('GotaVerde protege el dashboard para usuarios autenticados', function (): void {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

it('GotaVerde registra cuentas con contraseñas protegidas', function (): void {
    $this->post(route('register.store'), [
        'name' => 'Persona Demo',
        'email' => 'demo@example.test',
        'password' => 'ClaveSegura123!',
        'password_confirmation' => 'ClaveSegura123!',
    ])->assertRedirect(route('viviendas.create'));

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', ['email' => 'demo@example.test']);
    expect(User::where('email', 'demo@example.test')->first()->password)->not->toBe('ClaveSegura123!');
});

it('GotaVerde crea una vivienda y asigna al creador como propietario', function (): void {
    $usuario = User::factory()->create();

    $this->actingAs($usuario)->post(route('viviendas.store'), [
        'alias' => 'Casa de prueba',
        'tipo' => 'Casa',
        'habitantes' => 3,
        'alcaldia' => 'Iztapalapa',
        'codigo_postal' => '09000',
        'tarifa_m3' => '20.00',
    ])->assertRedirect(route('dashboard'));

    $vivienda = Vivienda::where('alias', 'Casa de prueba')->firstOrFail();
    $this->assertDatabaseHas('vivienda_usuario', [
        'user_id' => $usuario->id,
        'vivienda_id' => $vivienda->id,
        'rol' => 'propietario',
    ]);
});

it('GotaVerde impide cambiar a una vivienda ajena', function (): void {
    $usuario = User::factory()->create();
    $ajena = Vivienda::create([
        'alias' => 'Hogar privado', 'tipo' => 'Casa', 'habitantes' => 1,
        'alcaldia' => 'Coyoacán', 'codigo_postal' => '04000', 'tarifa_m3' => 0,
    ]);

    $this->actingAs($usuario)
        ->post(route('viviendas.seleccionar', $ajena))
        ->assertNotFound();
});

it('GotaVerde calcula cien litros para una ducha de diez minutos', function (): void {
    $usuario = User::factory()->create();
    $vivienda = Vivienda::create([
        'alias' => 'Casa ejemplo', 'tipo' => 'Departamento', 'habitantes' => 2,
        'alcaldia' => 'Tlalpan', 'codigo_postal' => '14000', 'tarifa_m3' => 20,
    ]);
    $vivienda->usuarios()->attach($usuario->id, ['rol' => 'propietario']);

    $actividad = Actividad::create([
        'clave' => 'ducha', 'nombre' => 'Ducha', 'unidad' => 'minuto',
        'litros_por_unidad' => 10, 'referencia_eficiente' => 5, 'activa' => true,
    ]);

    $this->actingAs($usuario)->post(route('habitos.store'), [
        'actividad_id' => $actividad->id,
        'cantidad' => 10,
        'fecha' => now()->toDateString(),
    ])->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('registros_habito', [
        'user_id' => $usuario->id,
        'vivienda_id' => $vivienda->id,
        'actividad_id' => $actividad->id,
        'litros_consumidos' => 100,
        'litros_ahorrados' => 0,
    ]);
});

it('GotaVerde no permite registrar actividades futuras', function (): void {
    $usuario = User::factory()->create();
    $vivienda = Vivienda::create([
        'alias' => 'Vivienda', 'tipo' => 'Casa', 'habitantes' => 1,
        'alcaldia' => 'Benito Juárez', 'codigo_postal' => '03100', 'tarifa_m3' => 0,
    ]);
    $vivienda->usuarios()->attach($usuario->id, ['rol' => 'propietario']);
    $actividad = Actividad::create([
        'clave' => 'ducha', 'nombre' => 'Ducha', 'unidad' => 'minuto',
        'litros_por_unidad' => 10, 'referencia_eficiente' => 5, 'activa' => true,
    ]);

    $this->actingAs($usuario)->post(route('habitos.store'), [
        'actividad_id' => $actividad->id,
        'cantidad' => 4,
        'fecha' => now()->addDay()->toDateString(),
    ])->assertSessionHasErrors('fecha');
});
