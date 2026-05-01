<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            // 🔥 tipo base
            $table->enum('type', ['ingredient', 'raw_material', 'product']);

            // 🧩 categoría (para agrupar)
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // 🔁 variantes (pan → pan chico)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('items')
                  ->nullOnDelete();

            // 📏 unidad base
            $table->string('unit'); // KG, LT, PZ

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};