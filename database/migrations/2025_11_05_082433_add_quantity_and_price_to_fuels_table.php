<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fuels', function (Blueprint $table) {
            $table->decimal('quantity', 8, 2)->default(0)->after('id');
            $table->decimal('price', 10, 2)->default(0)->after('quantity');
        });
    }

    public function down()
    {
        Schema::table('fuels', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'price']);
        });
    }
};
