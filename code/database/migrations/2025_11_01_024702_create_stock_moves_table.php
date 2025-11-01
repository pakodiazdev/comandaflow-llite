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
        Schema::create('stock_moves', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['IN', 'OUT', 'ADJUST', 'TRANSFER', 'CONSUME', 'PRODUCE']);
            $table->uuid('location_from_id')->nullable();
            $table->uuid('location_to_id')->nullable();
            $table->timestamp('moved_at');
            $table->uuid('ref_doc_id')->nullable();
            $table->string('ref_doc_type')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('location_from_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('location_to_id')->references('id')->on('locations')->onDelete('set null');

            // Indexes for performance
            $table->index('type');
            $table->index('location_from_id');
            $table->index('location_to_id');
            $table->index('moved_at');
            $table->index(['ref_doc_id', 'ref_doc_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_moves');
    }
};
