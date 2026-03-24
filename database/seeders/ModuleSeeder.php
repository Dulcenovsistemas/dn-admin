<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        Module::create([
            'name' => 'Recetario',
            'slug' => 'recetario'
        ]);

        Module::create([
            'name' => 'Producción',
            'slug' => 'produccion'
        ]);

        Module::create([
            'name' => 'Mantenimiento',
            'slug' => 'mantenimiento'
        ]);

        Module::create([
            'name' => 'RH',
            'slug' => 'rh'
        ]);

        Module::create([
            'name' => 'Auditorías',
            'slug' => 'auditorias'
        ]);
    }
}