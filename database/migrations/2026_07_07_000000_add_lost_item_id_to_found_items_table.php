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
        Schema::table('found_items', function (Blueprint $table) {
            $table->foreignId('lost_item_id')
                ->nullable()
                ->constrained('lost_items')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('found_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('lost_item_id');
        });
    }
};
