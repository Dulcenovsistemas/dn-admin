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
        Schema::create('ordenes_trabajo', function (Blueprint $table) {
            $table->id();

            // Folio
            $table->string('folio')->unique();

            // Relaciones
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('user_id')->constrained('users'); // Solicitante
            $table->string('tecnico')->nullable();

            // Categoría
            $table->enum('categoria', ['Equipo', 'Servicio']);

            // Relación según la categoría
            $table->foreignId('servicio_id')->nullable()->constrained('servicios');
            $table->string('equipo_id')->nullable();

            // Tipo de mantenimiento
            $table->enum('tipo_mantenimiento', [
                'Correctivo',
                'Preventivo',
                'Instalación',
                'Revisión',
                'Emergencia'
            ]);

            // Prioridad
            $table->enum('prioridad', [
                'Baja',
                'Media',
                'Alta',
                'Crítica'
            ])->default('Media');

            // Estado
            $table->enum('estado', [
                'Pendiente',
                'Asignada',
                'En proceso',
                'En espera',
                'Finalizada',
                'Cancelada'
            ])->default('Pendiente');

            // Información
            $table->text('descripcion');

            $table->text('solucion')->nullable();

            $table->text('observaciones')->nullable();

            $table->decimal('costo',10,2)->default(0);

            // Fechas
            $table->timestamp('fecha_programada')->nullable();

            $table->timestamp('fecha_inicio')->nullable();

            $table->timestamp('fecha_fin')->nullable();

            // Auditoría
            $table->foreignId('created_by')->constrained('users');

            $table->foreignId('closed_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_trabajo');
    }
};
