<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        $departamentos = [
            'Artigas', 'Canelones', 'Cerro Largo', 'Colonia', 'Durazno',
            'Flores', 'Florida', 'Lavalleja', 'Maldonado', 'Montevideo',
            'Paysandú', 'Río Negro', 'Rivera', 'Rocha', 'Salto',
            'San José', 'Soriano', 'Tacuarembó', 'Treinta y Tres',
        ];

        foreach ($departamentos as $nombre) {
            Departamento::create(['nombre' => $nombre]);
        }
    }
}
