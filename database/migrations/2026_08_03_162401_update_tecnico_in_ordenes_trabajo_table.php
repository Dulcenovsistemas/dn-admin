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
        Schema::table('ordenes_trabajo', function (Blueprint $table) {

            $table->dropColumn('tecnico');

            $table->foreignId('tecnico_id')
                ->nullable()
                ->after('user_id')
                ->constrained('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes_trabajo', function (Blueprint $table) {

            $table->dropConstrainedForeignId('tecnico_id');

            $table->string('tecnico')->nullable()->after('user_id');

        });
    }
};
