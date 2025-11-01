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
        Schema::create('bom_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('bom_id');
            $table->uuid('component_item_variant_id');
            $table->decimal('component_qty', 10, 4);
            $table->uuid('component_uom_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('bom_id')->references('id')->on('boms')->onDelete('cascade');
            $table->foreign('component_item_variant_id')->references('id')->on('item_variants')->onDelete('cascade');
            $table->foreign('component_uom_id')->references('id')->on('uoms')->onDelete('restrict');

            // Indexes for performance
            $table->index('bom_id');
            $table->index('component_item_variant_id');
            $table->index('component_uom_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_lines');
    }
};
