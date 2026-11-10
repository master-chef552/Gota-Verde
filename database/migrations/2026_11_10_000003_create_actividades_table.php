<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table): void {
            $table->id();
            $table->string('clave', 60)->unique();
            $table->string('nombre', 100);
            $table->string('unidad', 40);
            $table->decimal('litros_por_unidad', 10, 2);
            $table->decimal('referencia_eficiente', 10, 2);
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
