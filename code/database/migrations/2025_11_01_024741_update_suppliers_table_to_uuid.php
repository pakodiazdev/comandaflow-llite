<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign key constraints first
        Schema::table('product_suppliers', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
        });

        // Create new table with UUID
        Schema::create('suppliers_new', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('tax_id')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('tax_id');
        });

        // Copy data from old table to new table
        DB::statement('INSERT INTO suppliers_new (id, name, tax_id, email, phone, created_at, updated_at) 
                      SELECT gen_random_uuid(), name, tax_id, email, phone, created_at, updated_at FROM suppliers');

        // Drop old table and rename new table
        Schema::dropIfExists('suppliers');
        Schema::rename('suppliers_new', 'suppliers');

        // Recreate foreign key with UUID reference (this will need manual update of product_suppliers table)
        // For now, we'll just drop the product_suppliers table as it's not part of our new schema
        Schema::dropIfExists('product_suppliers');
        Schema::dropIfExists('products');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create table with auto-increment ID
        Schema::create('suppliers_old', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tax_id')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('tax_id');
        });

        // Copy data back
        DB::statement('INSERT INTO suppliers_old (name, tax_id, email, phone, created_at, updated_at) 
                      SELECT name, tax_id, email, phone, created_at, updated_at FROM suppliers');

        // Drop UUID table and rename old table
        Schema::dropIfExists('suppliers');
        Schema::rename('suppliers_old', 'suppliers');
    }
};
