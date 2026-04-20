<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ingredients', function (Blueprint $table) {
            $table->decimal('cost_per_bucket', 10, 2)->nullable()->after('cost_per_unit');
            $table->decimal('cost_per_liter', 10, 2)->nullable()->after('cost_per_bucket');
        });
    }

    public function down()
    {
        Schema::table('ingredients', function (Blueprint $table) {
            $table->dropColumn(['cost_per_bucket', 'cost_per_liter']);
        });
    }
};
