<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registros_habito', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('vivienda_id')->constrained('viviendas')->cascadeOnDelete();
            $table->foreignId('actividad_id')->constrained('actividades')->restrictOnDelete();
            $table->date('fecha');
            $table->decimal('cantidad', 10, 2);
            $table->decimal('litros_consumidos', 12, 2);
            $table->decimal('litros_ahorrados', 12, 2);
            $table->timestamps();
            $table->index(['vivienda_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registros_habito');
    }
};
