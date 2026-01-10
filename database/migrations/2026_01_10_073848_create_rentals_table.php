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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->restrictOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->tinyInteger('status')->comment('1: booked, 2: active, 3: completed, 4: cancelled');
            $table->tinyInteger('billing_period')->comment('1: daily, 2: weekly, 3: monthly');
            $table->foreignId('rate_plan_id')->constrained('rate_plans')->restrictOnDelete();
            $table->decimal('price_snapshot', 15, 2);
            $table->decimal('deposit_amount', 15, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['room_id', 'start_date', 'end_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
