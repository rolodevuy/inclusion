<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    public $timestamps = false;

    protected $table = 'habilidades';

    protected $fillable = ['nombre', 'categoria_laboral_id'];

    public function categoriaLaboral()
    {
        return $this->belongsTo(CategoriaLaboral::class, 'categoria_laboral_id');
    }
}
