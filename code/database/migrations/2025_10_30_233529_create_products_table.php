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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('unit_of_measure')->default('unit'); // unit, kg, lbs, liters, etc.
            $table->decimal('current_stock', 10, 2)->default(0);
            $table->decimal('minimum_stock', 10, 2)->default(0);
            $table->decimal('maximum_stock', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->decimal('selling_price', 10, 2)->nullable();
            $table->string('barcode')->nullable();
            $table->boolean('is_perishable')->default(false);
            $table->integer('shelf_life_days')->nullable(); // for perishable items
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'category']);
            $table->index('sku');
            $table->index('name');
            $table->index('current_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
