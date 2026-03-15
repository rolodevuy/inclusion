<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    protected $table = 'postulaciones';

    protected $fillable = [
        'oferta_empleo_id',
        'candidato_user_id',
        'mensaje',
        'estado',
    ];

    public function oferta()
    {
        return $this->belongsTo(OfertaEmpleo::class, 'oferta_empleo_id');
    }

    public function candidato()
    {
        return $this->belongsTo(User::class, 'candidato_user_id');
    }
}
