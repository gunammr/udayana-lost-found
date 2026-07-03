<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'avatar_path')) {
                $table->string('avatar_path')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('phone');
            }
            if (!Schema::hasColumn('users', 'nim')) {
                $table->string('nim')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'tahun_angkatan')) {
                $table->string('tahun_angkatan')->nullable()->after('nim');
            }
            if (!Schema::hasColumn('users', 'program_studi')) {
                $table->string('program_studi')->nullable()->after('tahun_angkatan');
            }
            if (!Schema::hasColumn('users', 'fakultas')) {
                $table->string('fakultas')->nullable()->after('program_studi');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('fakultas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['avatar_path', 'phone', 'role', 'nim', 'tahun_angkatan', 'program_studi', 'fakultas', 'bio'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};