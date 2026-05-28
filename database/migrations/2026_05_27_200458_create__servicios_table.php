<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {

            $table->id();

            $table->foreignId('sucursal_id')
                ->constrained('branches')
                ->cascadeOnDelete();

            $table->foreignId('area_id')
                ->constrained()
                ->cascadeOnDelete();

            // Tipo de servicio
            $table->enum('tipo_servicio', [
                'Luz',
                'Agua',
                'Internet',
                'Telefonia',
                'Gas',
                'Seguridad',
                'Otro'
            ]);

            // Nombre o descripción corta
            $table->string('nombre');

            // Información extra
            $table->text('descripcion')->nullable();

            // Datos del proveedor
            $table->string('proveedor')->nullable();

            // Número de contrato o cuenta
            $table->string('numero_contrato')->nullable();

            // Costo mensual aproximado
            $table->decimal('costo_mensual', 10, 2)->nullable();

            // Fecha de inicio del servicio
            $table->date('fecha_inicio')->nullable();

            // Estado del servicio
            $table->enum('estatus', [
                'Activo',
                'Suspendido',
                'Cancelado'
            ])->default('Activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};