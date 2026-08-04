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
        Schema::create('ordenes_trabajo_evidencias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('orden_trabajo_id')
                ->constrained('ordenes_trabajo')
                ->cascadeOnDelete();

            $table->string('archivo');

            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_trabajo_evidencias');
    }
};
