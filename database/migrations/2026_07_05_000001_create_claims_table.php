<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();

            // Siapa yang mengajukan klaim
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Barang ditemukan yang diklaim
            $table->foreignId('found_item_id')->constrained()->cascadeOnDelete();

            // Alasan/bukti klaim dari pemohon
            $table->text('message');

            // Status klaim: menunggu | diterima | ditolak
            $table->string('status', 30)->default('menunggu');

            // Catatan balasan dari pelapor / admin
            $table->text('admin_note')->nullable();

            $table->timestamps();

            // Satu user hanya boleh mengajukan klaim sekali per barang
            $table->unique(['user_id', 'found_item_id']);

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
