<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidatoExperiencia extends Model
{
    protected $fillable = [
        'candidato_profile_id',
        'cargo',
        'empresa',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    public function profile()
    {
        return $this->belongsTo(CandidatoProfile::class, 'candidato_profile_id');
    }
}
