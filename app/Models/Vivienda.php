<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vivienda extends Model
{
    protected $table = 'viviendas';

    protected $fillable = [
        'alias', 'tipo', 'habitantes', 'alcaldia', 'codigo_postal', 'tarifa_m3',
    ];

    protected function casts(): array
    {
        return ['habitantes' => 'integer', 'tarifa_m3' => 'decimal:2'];
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'vivienda_usuario', 'vivienda_id', 'user_id')
            ->withPivot('rol')
            ->withTimestamps();
    }

    public function registros(): HasMany
    {
        return $this->hasMany(RegistroHabito::class, 'vivienda_id');
    }
}
