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
        Schema::table('fuels', function (Blueprint $table) {
            $table->decimal('quantity', 10, 2)->after('liters')->nullable();
        });
    }

    public function down()
    {
        Schema::table('fuels', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
};
