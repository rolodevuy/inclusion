<?php

namespace Database\Seeders;

use App\Models\CategoriaLaboral;
use Illuminate\Database\Seeder;

class CategoriaLaboralSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Administración y Oficina',
            'Atención al Cliente',
            'Comercio y Ventas',
            'Comunicación y Marketing',
            'Contabilidad y Finanzas',
            'Diseño y Creatividad',
            'Educación y Capacitación',
            'Gastronomía y Turismo',
            'Logística y Transporte',
            'Mantenimiento y Limpieza',
            'Producción y Manufactura',
            'Salud y Bienestar',
            'Tecnología e Informática',
            'Trabajo Social y Comunitario',
            'Otro',
        ];

        foreach ($categorias as $nombre) {
            CategoriaLaboral::create(['nombre' => $nombre]);
        }
    }
}
