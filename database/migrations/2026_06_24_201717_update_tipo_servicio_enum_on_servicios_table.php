<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE servicios
            MODIFY COLUMN tipo_servicio ENUM(
                'Internet',
                'Camaras',
                'Electricidad',
                'Gas LP',
                'Baños',
                'Agua',
                'Drenaje',
                'Seguridad',
                'Pared',
                'Techo',
                'Piso',
                'Movilidad'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE servicios
            MODIFY COLUMN tipo_servicio ENUM(
                'Luz',
                'Agua',
                'Internet',
                'Telefonia',
                'Gas',
                'Seguridad',
                'Otro'
            ) NOT NULL
        ");
    }
};