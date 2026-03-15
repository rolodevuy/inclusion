<?php

namespace Database\Seeders;

use App\Models\CategoriaLaboral;
use App\Models\Habilidad;
use Illuminate\Database\Seeder;

class HabilidadSeeder extends Seeder
{
    public function run(): void
    {
        $habilidadesPorCategoria = [
            'Administración y Oficina' => [
                'Gestión documental', 'Archivo y organización', 'Manejo de agenda',
                'Atención telefónica', 'Redacción',
            ],
            'Tecnología e Informática' => [
                'Ofimática (Word, Excel, PowerPoint)', 'Soporte técnico', 'Programación',
                'Diseño web', 'Manejo de redes sociales', 'Entrada de datos',
            ],
            'Atención al Cliente' => [
                'Comunicación verbal', 'Resolución de problemas', 'Empatía',
                'Manejo de quejas', 'Atención presencial',
            ],
            'Comercio y Ventas' => [
                'Ventas', 'Negociación', 'Atención en mostrador',
                'Inventario', 'Caja registradora',
            ],
            'Diseño y Creatividad' => [
                'Diseño gráfico', 'Fotografía', 'Edición de video',
                'Ilustración', 'Artesanía',
            ],
        ];

        foreach ($habilidadesPorCategoria as $categoriaNombre => $habilidades) {
            $categoria = CategoriaLaboral::where('nombre', $categoriaNombre)->first();
            foreach ($habilidades as $nombre) {
                Habilidad::create([
                    'nombre' => $nombre,
                    'categoria_laboral_id' => $categoria?->id,
                ]);
            }
        }

        // Habilidades transversales (sin categoría)
        $transversales = [
            'Trabajo en equipo', 'Puntualidad', 'Responsabilidad',
            'Adaptabilidad', 'Aprendizaje continuo', 'Organización',
            'Comunicación escrita',
        ];

        foreach ($transversales as $nombre) {
            Habilidad::create([
                'nombre' => $nombre,
                'categoria_laboral_id' => null,
            ]);
        }
    }
}
