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
        Schema::create('asset_depreciations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('asset_id');
            $table->date('period');
            $table->decimal('amount', 12, 2);
            $table->boolean('posted')->default(false);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');

            // Unique constraint on asset + period
            $table->unique(['asset_id', 'period']);

            // Indexes for performance
            $table->index('asset_id');
            $table->index('period');
            $table->index('posted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_depreciations');
    }
};
