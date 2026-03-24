<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
   public function run()
    {
        DB::table('branches')->insert([
            [
                'name' => 'Planta Cuauhtémoc',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Operadora',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Manzanela',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sucursal matriz café',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sucursal ctm',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
