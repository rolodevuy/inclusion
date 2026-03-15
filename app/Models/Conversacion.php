<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    protected $table = 'conversaciones';

    protected $fillable = [
        'empresa_user_id',
        'candidato_user_id',
        'asunto',
    ];

    public function empresa()
    {
        return $this->belongsTo(User::class, 'empresa_user_id');
    }

    public function candidato()
    {
        return $this->belongsTo(User::class, 'candidato_user_id');
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'conversacion_id');
    }

    public function ultimoMensaje()
    {
        return $this->hasOne(Mensaje::class, 'conversacion_id')->latestOfMany();
    }

    public function mensajesNoLeidos(int $userId)
    {
        return $this->mensajes()
            ->whereNull('leido_at')
            ->where('remitente_user_id', '!=', $userId)
            ->count();
    }

    public function otroUsuario(User $user): User
    {
        return $user->id === $this->empresa_user_id
            ? $this->candidato
            : $this->empresa;
    }
}
