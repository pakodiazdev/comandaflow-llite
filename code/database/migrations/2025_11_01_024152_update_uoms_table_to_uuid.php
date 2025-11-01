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
        // First, drop foreign key constraints if any exist
        Schema::table('uoms', function (Blueprint $table) {
            $table->dropIndex('uoms_code_index');
        });

        // Create new table with UUID
        Schema::create('uoms_new', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 16)->unique();
            $table->string('name', 64);
            $table->timestamps();
            
            // Index for better performance
            $table->index('code');
        });

        // Copy data from old table to new table
        DB::statement('INSERT INTO uoms_new (id, code, name, created_at, updated_at) 
                      SELECT gen_random_uuid(), code, name, created_at, updated_at FROM uoms');

        // Drop old table and rename new table
        Schema::dropIfExists('uoms');
        Schema::rename('uoms_new', 'uoms');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create table with auto-increment ID
        Schema::create('uoms_old', function (Blueprint $table) {
            $table->id();
            $table->string('code', 16)->unique();
            $table->string('name', 64);
            $table->timestamps();
            
            // Index for better performance
            $table->index('code');
        });

        // Copy data back
        DB::statement('INSERT INTO uoms_old (code, name, created_at, updated_at) 
                      SELECT code, name, created_at, updated_at FROM uoms');

        // Drop UUID table and rename old table
        Schema::dropIfExists('uoms');
        Schema::rename('uoms_old', 'uoms');
    }
};
