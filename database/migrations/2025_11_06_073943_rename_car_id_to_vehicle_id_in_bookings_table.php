<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Rename car_id to vehicle_id
            $table->renameColumn('car_id', 'vehicle_id');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Rollback
            $table->renameColumn('vehicle_id', 'car_id');
        });
    }
};
