<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE found_items
            SET category_id = (
                SELECT id FROM categories WHERE categories.category = found_items.category
            )
        ");

        DB::statement("
            UPDATE lost_items
            SET category_id = (
                SELECT id FROM categories WHERE categories.category = lost_items.category
            )
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