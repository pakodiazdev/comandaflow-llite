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
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('item_id');
            $table->string('serial')->unique();
            $table->decimal('acquisition_cost', 12, 2);
            $table->date('acquisition_date');
            $table->integer('useful_life_months');
            $table->decimal('salvage_value', 12, 2)->default(0);
            $table->enum('depreciation_method', ['STRAIGHT_LINE'])->default('STRAIGHT_LINE');
            $table->enum('status', ['ACTIVE', 'DISPOSED', 'MAINTENANCE'])->default('ACTIVE');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');

            // Indexes for performance
            $table->index('item_id');
            $table->index('serial');
            $table->index('status');
            $table->index('acquisition_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
