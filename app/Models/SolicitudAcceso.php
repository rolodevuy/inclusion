<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudAcceso extends Model
{
    protected $table = 'solicitudes_acceso';

    protected $fillable = [
        'empresa_user_id',
        'candidato_profile_id',
        'estado',
        'mensaje',
    ];

    public function empresa()
    {
        return $this->belongsTo(User::class, 'empresa_user_id');
    }

    public function candidatoProfile()
    {
        return $this->belongsTo(CandidatoProfile::class, 'candidato_profile_id');
    }
}
