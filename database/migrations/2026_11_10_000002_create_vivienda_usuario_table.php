<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vivienda_usuario', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('vivienda_id')->constrained('viviendas')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('rol', 20)->default('miembro');
            $table->timestamps();
            $table->unique(['vivienda_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vivienda_usuario');
    }
};
