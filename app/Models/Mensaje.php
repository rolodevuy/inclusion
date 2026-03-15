<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'mensajes';

    protected $fillable = [
        'conversacion_id',
        'remitente_user_id',
        'contenido',
        'leido_at',
    ];

    protected function casts(): array
    {
        return [
            'leido_at' => 'datetime',
        ];
    }

    public function conversacion()
    {
        return $this->belongsTo(Conversacion::class, 'conversacion_id');
    }

    public function remitente()
    {
        return $this->belongsTo(User::class, 'remitente_user_id');
    }
}
