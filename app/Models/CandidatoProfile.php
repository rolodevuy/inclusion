<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidatoProfile extends Model
{
    protected $fillable = [
        'user_id',
        'departamento_id',
        'categoria_laboral_id',
        'modalidad_trabajo',
        'nivel_educativo',
        'sobre_mi',
        'tipo_discapacidad',
        'tiene_certificado',
        'necesidades_adaptacion',
        'visibilidad_discapacidad',
        'certificado_path',
        'certificado_estado',
        'certificado_observaciones',
    ];

    protected function casts(): array
    {
        return [
            'tiene_certificado' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function categoriaLaboral()
    {
        return $this->belongsTo(CategoriaLaboral::class, 'categoria_laboral_id');
    }

    public function habilidades()
    {
        return $this->belongsToMany(Habilidad::class, 'candidato_habilidad', 'candidato_profile_id', 'habilidad_id');
    }

    public function experiencias()
    {
        return $this->hasMany(CandidatoExperiencia::class, 'candidato_profile_id');
    }

    public function solicitudesAcceso()
    {
        return $this->hasMany(SolicitudAcceso::class, 'candidato_profile_id');
    }
}
