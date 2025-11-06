<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('license_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->string('route')->nullable();
            $table->enum('status', ['Available', 'Inactive'])->default('Available');
            $table->timestamps();
            $table->enum('driver_availability', ['yes','no'])->default('yes');


            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};
