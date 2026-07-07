<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE found_items f
            JOIN categories c
                ON f.category = c.category
            SET f.category_id = c.id
        ");

        DB::statement("
            UPDATE lost_items l
            JOIN categories c
                ON l.category = c.category
            SET l.category_id = c.id
        ");
    }

    public function down(): void
    {
        DB::statement("
            UPDATE found_items
            SET category_id = NULL
        ");

        DB::statement("
            UPDATE lost_items
            SET category_id = NULL
        ");
    }
};