<?php

namespace Database\Seeders;

use App\Models\JobPosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $puestos = [
            'TRASTES',
            'ENHARINADO',
            'AUXILIAR MULTIPLE',
            'PEGADO',
            'DECORADOR (A)',
            'SUPERVISOR (A)',
            'TECNICO',
            'PANADERO(A)',
            'PREPARACION',
            'AUXILIAR',
            'HORNEADOR (A)',
            'JEFE (A) DE AREA',
            'EMPAQUETADO',
            'LIMPIEZA',
            'GUARDIA',
            'CHOFER',
            'ENCARGADO',
            'GERENCIA',
            'MOSTRADOR',
            'BARISTA'
        ];

        foreach ($puestos as $puesto) {
            JobPosition::firstOrCreate([
                'name' => $puesto
            ]);
        }
    }
}
