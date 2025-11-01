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
        Schema::create('stock_layers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('item_variant_id');
            $table->uuid('location_id');
            $table->uuid('lot_id')->nullable();
            $table->decimal('qty_in', 10, 4)->default(0);
            $table->decimal('qty_out', 10, 4)->default(0);
            $table->decimal('unit_cost', 10, 4);
            $table->timestamp('received_at');
            $table->timestamp('expiry_at')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('item_variant_id')->references('id')->on('item_variants')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('lot_id')->references('id')->on('lots')->onDelete('set null');

            // Indexes for performance
            $table->index('item_variant_id');
            $table->index('location_id');
            $table->index('lot_id');
            $table->index('received_at');
            $table->index('expiry_at');

            // Composite index for stock queries
            $table->index(['item_variant_id', 'location_id', 'lot_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_layers');
    }
};
