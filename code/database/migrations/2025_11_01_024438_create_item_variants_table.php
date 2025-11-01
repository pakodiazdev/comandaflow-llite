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
        Schema::create('item_variants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('item_id');
            $table->string('code');
            $table->string('name');
            $table->uuid('uom_id');
            $table->boolean('track_lot')->default(false);
            $table->boolean('track_serial')->default(false);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('uom_id')->references('id')->on('uoms')->onDelete('restrict');

            // Unique constraint on item_id + code
            $table->unique(['item_id', 'code']);

            // Indexes for performance
            $table->index('item_id');
            $table->index('code');
            $table->index('uom_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_variants');
    }
};
