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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Vehicle name (instead of vehicle_name)
            $table->string('model')->nullable();
            $table->string('license_plate')->unique();
            $table->string('type')->nullable(); // Car, Truck, Bus etc.
            $table->year('manufacture_year')->nullable();
            $table->integer('mileage')->default(0);
            $table->string('status')->default('active'); // active / inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
