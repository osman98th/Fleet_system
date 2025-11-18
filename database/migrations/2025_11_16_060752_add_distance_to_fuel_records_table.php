<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('fuel_records', function (Blueprint $table) {
            $table->decimal('distance', 8, 2)->nullable()->after('cost');
            // 8 digits total, 2 decimal places, adjust as needed
        });
    }

    public function down(): void
    {
        Schema::table('fuel_records', function (Blueprint $table) {
            $table->dropColumn('distance');
        });
    }
};
