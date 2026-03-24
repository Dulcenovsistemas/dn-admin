<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModulePermission;

class ModulePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModulePermission::insert([
        [
        'user_id'=>1,
        'module_id'=>1,
        'can_view'=>1,
        'can_create'=>1,
        'can_edit'=>1,
        'can_delete'=>1
        ],
        [
        'user_id'=>1,
        'module_id'=>2,
        'can_view'=>1,
        'can_create'=>1,
        'can_edit'=>1,
        'can_delete'=>1
        ],
        [
        'user_id'=>1,
        'module_id'=>3,
        'can_view'=>1,
        'can_create'=>1,
        'can_edit'=>1,
        'can_delete'=>1
        ]
        ]);
    }
}
