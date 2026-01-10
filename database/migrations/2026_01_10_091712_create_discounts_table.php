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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('type'); // 0=percentage, 1=fixed
            $table->decimal('value', 12, 2);

            $table->unsignedTinyInteger('applies_to')->default(0); // 0=all, 1=daily, 2=weekly, 3=monthly
            $table->date('valid_from');
            $table->date('valid_to');

            $table->integer('priority')->default(0);
            $table->boolean('is_stackable')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'valid_from', 'valid_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
