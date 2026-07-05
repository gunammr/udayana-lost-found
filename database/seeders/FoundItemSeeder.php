<?php

namespace Database\Seeders;

use App\Models\FoundItem;
use Illuminate\Database\Seeder;

class FoundItemSeeder extends Seeder
{
    public function run(): void
    {
        FoundItem::factory()->count(12)->create();
    }
}
