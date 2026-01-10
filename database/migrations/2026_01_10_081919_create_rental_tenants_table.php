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
        // this table is to accommodate multiple tenants renting a single room under a single rental agreement
        Schema::create('rental_tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals')->restrictOnDelete();
            $table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->restrictOnDelete();
            $table->date('start_date')->comment('The date the tenant started renting the room');
            $table->date('actual_end_date')->nullable()->comment('The actual date the tenant ended renting the room');
            $table->tinyInteger('status')->comment('1: active, 2: inactive');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_tenants');
    }
};
