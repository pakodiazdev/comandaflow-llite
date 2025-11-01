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
        Schema::create('stock_move_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('stock_move_id');
            $table->uuid('item_variant_id');
            $table->uuid('lot_id')->nullable();
            $table->decimal('qty', 10, 4);
            $table->decimal('unit_cost', 10, 4);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('stock_move_id')->references('id')->on('stock_moves')->onDelete('cascade');
            $table->foreign('item_variant_id')->references('id')->on('item_variants')->onDelete('cascade');
            $table->foreign('lot_id')->references('id')->on('lots')->onDelete('set null');

            // Indexes for performance
            $table->index('stock_move_id');
            $table->index('item_variant_id');
            $table->index('lot_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_move_lines');
    }
};
