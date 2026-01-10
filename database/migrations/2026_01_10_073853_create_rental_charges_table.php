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
        Schema::create('rental_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals')->cascadeOnDelete();
            $table->tinyInteger('type')->comment('1: base_rent, 2: addon, 3: fine, 4: discount');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2)->comment('positive for charges, negative for discounts');
            $table->dateTime('charged_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_charges');
    }
};
