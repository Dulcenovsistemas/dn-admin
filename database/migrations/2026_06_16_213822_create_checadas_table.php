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
        Schema::create('checadas', function (Blueprint $table) {
            $table->id();

            $table->string('empleado_id');
            $table->string('nombre');
            $table->string('departamento')->nullable();

            $table->date('fecha');

            $table->time('entrada')->nullable();
            $table->time('salida')->nullable();

            $table->decimal('horas_trabajadas', 8, 2)->nullable();
            $table->decimal('horas_extra', 8, 2)->nullable();

            $table->string('observaciones')->nullable();

            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checadas');
    }
};
