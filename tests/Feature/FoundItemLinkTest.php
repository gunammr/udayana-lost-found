<?php

namespace Tests\Feature;

use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoundItemLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_found_item_form_can_be_opened_from_a_lost_item(): void
    {
        $lostItem = LostItem::create([
            'item_name' => 'Dompet Hitam',
            'category' => 'Aksesori',
            'incident_date' => now()->toDateString(),
            'location' => 'Parkiran Rektorat',
            'description' => 'Dompet hitam berisi kartu identitas.',
            'reporter_name' => 'Made Wijaya',
            'phone' => '081234567890',
            'status' => 'menunggu_verifikasi',
        ]);

        $this->get(route('found-items.create', ['lost_item_id' => $lostItem->id]))
            ->assertOk()
            ->assertSee('Menanggapi laporan barang hilang')
            ->assertSee('Dompet Hitam');
    }

    public function test_found_item_report_can_be_linked_to_a_lost_item(): void
    {
        $lostItem = LostItem::create([
            'item_name' => 'Dompet Hitam',
            'category' => 'Aksesori',
            'incident_date' => now()->toDateString(),
            'location' => 'Parkiran Rektorat',
            'description' => 'Dompet hitam berisi kartu identitas.',
            'reporter_name' => 'Made Wijaya',
            'phone' => '081234567890',
            'status' => 'menunggu_verifikasi',
        ]);

        $response = $this->post(route('found-items.store'), [
            'lost_item_id' => $lostItem->id,
            'item_name' => 'Dompet Hitam',
            'category' => 'Aksesori',
            'incident_date' => now()->toDateString(),
            'location' => 'Pos Satpam Rektorat',
            'description' => 'Saya menemukan dompet ini dan menitipkannya di pos satpam.',
            'reporter_name' => 'Komang Putra',
            'phone' => '081298765432',
        ]);

        $response->assertRedirect(route('found-items.create'));

        $foundItem = FoundItem::first();

        $this->assertNotNull($foundItem);
        $this->assertSame($lostItem->id, $foundItem->lost_item_id);
        $this->assertSame('Pos Satpam Rektorat', $foundItem->location);
    }
}
