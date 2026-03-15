<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertaEmpleo extends Model
{
    protected $table = 'ofertas_empleo';

    protected $fillable = [
        'empresa_user_id',
        'titulo',
        'descripcion',
        'categoria_laboral_id',
        'departamento_id',
        'modalidad',
        'horario',
        'requisitos',
        'beneficios',
        'adaptaciones_disponibles',
        'estado',
    ];

    public function empresa()
    {
        return $this->belongsTo(User::class, 'empresa_user_id');
    }

    public function categoriaLaboral()
    {
        return $this->belongsTo(CategoriaLaboral::class, 'categoria_laboral_id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class, 'oferta_empleo_id');
    }
}
