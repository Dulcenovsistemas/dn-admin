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
        Schema::table('employees', function (Blueprint $table) {

            // 🔵 Datos personales
            $table->string('last_name')->nullable();
            $table->string('second_last_name')->nullable();

            $table->date('birth_date')->nullable();

            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // 🟢 Datos laborales
            $table->string('department')->nullable();

            $table->string('status')
                ->default('active');

            // 🟡 Datos fiscales
            $table->string('curp')->nullable();
            $table->string('rfc')->nullable();
            $table->string('imss')->nullable();
            $table->string('clabe')->nullable();

            // 📸 Foto
            $table->string('photo')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            $table->dropColumn([
                'last_name',
                'second_last_name',
                'birth_date',
                'phone',
                'address',
                'department',
                'status',
                'curp',
                'rfc',
                'imss',
                'clabe',
                'photo'
            ]);

        });
    }
};