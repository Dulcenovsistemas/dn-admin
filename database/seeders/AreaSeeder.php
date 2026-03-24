<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        DB::table('areas')->insert([
            [
                'name' => 'Decorado',
                'branch_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Horneo',
                'branch_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Almacén',
                'branch_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Empaque',
                'branch_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
