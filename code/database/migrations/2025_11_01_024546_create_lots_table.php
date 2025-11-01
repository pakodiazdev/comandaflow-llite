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
        Schema::create('lots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('lot_code')->unique();
            $table->timestamp('manufactured_at')->nullable();
            $table->timestamp('expiry_at')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('lot_code');
            $table->index('expiry_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
