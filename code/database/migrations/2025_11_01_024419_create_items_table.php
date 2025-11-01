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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('sku')->unique();
            $table->string('name');
            $table->enum('type', ['INSUMO', 'PRODUCTO', 'ACTIVO']);
            $table->boolean('is_stocked')->default(true);
            $table->boolean('is_perishable')->default(false);
            $table->uuid('default_uom_id')->nullable();
            $table->boolean('has_variants')->default(false);
            $table->decimal('selling_price', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('default_uom_id')->references('id')->on('uoms')->onDelete('set null');

            // Indexes for performance
            $table->index('sku');
            $table->index('type');
            $table->index('is_stocked');
            $table->index('has_variants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
