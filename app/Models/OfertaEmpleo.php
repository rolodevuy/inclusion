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
        'salario_min',
        'salario_max',
        'salario_moneda',
        'salario_visible',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'salario_visible' => 'boolean',
        ];
    }

    public function salarioFormateado(): ?string
    {
        if (!$this->salario_min && !$this->salario_max) {
            return null;
        }

        $moneda = $this->salario_moneda === 'USD' ? 'US$' : '$';

        if ($this->salario_min && $this->salario_max) {
            return $moneda . ' ' . number_format($this->salario_min, 0, ',', '.') . ' - ' . number_format($this->salario_max, 0, ',', '.');
        }

        if ($this->salario_min) {
            return 'Desde ' . $moneda . ' ' . number_format($this->salario_min, 0, ',', '.');
        }

        return 'Hasta ' . $moneda . ' ' . number_format($this->salario_max, 0, ',', '.');
    }

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
