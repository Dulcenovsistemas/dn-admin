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
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');

            $table->integer('available_days')->default(0);
            $table->integer('taken_days')->default(0);
            $table->integer('balance_days')->default(0);

            $table->decimal('salary_daily', 10, 2)->default(0);
            $table->decimal('vacation_pay', 10, 2)->default(0);
            $table->decimal('prima_vacacional', 10, 2)->default(0);
            $table->decimal('total_pay', 10, 2)->default(0);

            $table->decimal('prima_percentage', 5, 2)->default(25);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacations');
    }
};
