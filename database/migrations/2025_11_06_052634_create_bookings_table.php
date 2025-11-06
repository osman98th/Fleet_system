<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->date('rent_start_date');
            $table->date('rent_end_date');
            $table->enum('car_type',['ac','non_ac']);
            $table->enum('charge_type',['km','days']);
            $table->decimal('distance',8,2)->nullable();
            $table->decimal('fare',10,2);
            $table->enum('status',['pending','confirmed','completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
