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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->foreignId('room_type_id')->constrained('room_types')->restrictOnDelete();
            $table->string('name');
            $table->tinyInteger('status')->default(0)->comment('0: available, 1: occupied, 2: maintenance, 3: inactive');
            $table->json('allowed_billing_periods')->nullable()->comment('Array of allowed billing periods for this room (1: daily, 2: weekly, 3: monthly)');
            $table->json('features')->nullable()->comment('JSON array of room features');
            $table->string('image_url')->nullable();
            $table->json('image_urls')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['room_type_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
