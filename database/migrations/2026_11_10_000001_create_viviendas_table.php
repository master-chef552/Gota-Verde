<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('viviendas', function (Blueprint $table): void {
            $table->id();
            $table->string('alias', 100);
            $table->string('tipo', 80);
            $table->unsignedTinyInteger('habitantes');
            $table->string('alcaldia', 100);
            $table->string('codigo_postal', 5);
            $table->decimal('tarifa_m3', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viviendas');
    }
};
