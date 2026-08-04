<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
   use Illuminate\Support\Facades\DB;

return new class extends Migration
{


    public function up(): void
    {
        DB::statement("
            ALTER TABLE ordenes_trabajo
            MODIFY estado ENUM(
                'Pendiente',
                'Asignada',
                'En proceso',
                'En espera',
                'Esperando validación',
                'Finalizada',
                'Cancelada'
            ) DEFAULT 'Pendiente'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE ordenes_trabajo
            MODIFY estado ENUM(
                'Pendiente',
                'Asignada',
                'En proceso',
                'En espera',
                'Finalizada',
                'Cancelada'
            ) DEFAULT 'Pendiente'
        ");
    }
};
