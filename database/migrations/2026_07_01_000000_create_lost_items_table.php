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
        Schema::create('lost_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item_name', 120);
            $table->string('category', 50);
            $table->date('incident_date');
            $table->string('location', 180);
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->string('reporter_name', 120);
            $table->string('phone', 30);
            $table->string('status', 40)->default('menunggu_verifikasi');
            $table->timestamps();

            $table->index(['category', 'status']);
            $table->index('incident_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_items');
    }
};
