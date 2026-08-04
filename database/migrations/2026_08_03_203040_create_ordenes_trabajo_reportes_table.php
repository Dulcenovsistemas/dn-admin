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
        Schema::create('ordenes_trabajo_reportes', function (Blueprint $table) {

            $table->id();

            // Orden relacionada
            $table->foreignId('orden_trabajo_id')
                ->constrained('ordenes_trabajo')
                ->cascadeOnDelete();

            // Técnico que realizó el trabajo
            $table->foreignId('tecnico_id')
                ->constrained('users');

            // Fechas del servicio
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();

            // Diagnóstico inicial
            $table->text('diagnostico')->nullable();

            // Solución aplicada
            $table->text('solucion');

            // Materiales o refacciones utilizadas
            $table->text('materiales')->nullable();

            // Observaciones finales
            $table->text('observaciones')->nullable();

            // Costo del servicio
            $table->decimal('costo', 10, 2)->default(0);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_trabajo_reportes');
    }
};