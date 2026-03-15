<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaProfile extends Model
{
    protected $fillable = [
        'user_id',
        'rut',
        'sector',
        'descripcion',
        'departamento_id',
        'sitio_web',
        'logo',
        'politicas_inclusion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}
