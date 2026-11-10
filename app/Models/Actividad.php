<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actividad extends Model
{
    protected $table = 'actividades';

    protected $fillable = [
        'clave', 'nombre', 'unidad', 'litros_por_unidad', 'referencia_eficiente', 'activa',
    ];

    protected function casts(): array
    {
        return [
            'litros_por_unidad' => 'decimal:2',
            'referencia_eficiente' => 'decimal:2',
            'activa' => 'boolean',
        ];
    }

    public function registros(): HasMany
    {
        return $this->hasMany(RegistroHabito::class, 'actividad_id');
    }
}
