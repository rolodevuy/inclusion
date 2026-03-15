<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaLaboral extends Model
{
    public $timestamps = false;

    protected $table = 'categorias_laborales';

    protected $fillable = ['nombre'];

    public function habilidades()
    {
        return $this->hasMany(Habilidad::class, 'categoria_laboral_id');
    }
}
