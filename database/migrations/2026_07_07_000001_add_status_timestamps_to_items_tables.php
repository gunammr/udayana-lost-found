<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Lost Items ──────────────────────────────────────────────────
        // Status baru: hilang → dicari → ditemukan → selesai
        Schema::table('lost_items', function (Blueprint $table) {
            // Ubah default status
            $table->string('status', 40)->default('hilang')->change();

            // Timestamp tiap tahapan status
            $table->timestamp('dicari_at')->nullable()->after('status');
            $table->timestamp('ditemukan_at')->nullable()->after('dicari_at');
            $table->timestamp('selesai_at')->nullable()->after('ditemukan_at');
        });

        // ── Found Items ──────────────────────────────────────────────────
        // Status baru: ditemukan → diklaim → dikembalikan → selesai
        Schema::table('found_items', function (Blueprint $table) {
            // Ubah default status
            $table->string('status', 40)->default('ditemukan')->change();

            // Timestamp tiap tahapan status
            $table->timestamp('diklaim_at')->nullable()->after('status');
            $table->timestamp('dikembalikan_at')->nullable()->after('diklaim_at');
            $table->timestamp('selesai_at')->nullable()->after('dikembalikan_at');
        });
    }

    public function down(): void
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->dropColumn(['dicari_at', 'ditemukan_at', 'selesai_at']);
        });

        Schema::table('found_items', function (Blueprint $table) {
            $table->dropColumn(['diklaim_at', 'dikembalikan_at', 'selesai_at']);
        });
    }
};
