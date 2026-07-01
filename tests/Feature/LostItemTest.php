<?php

namespace Tests\Feature;

use App\Models\LostItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LostItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_the_lost_item_report_form(): void
    {
        $this->get(route('lost-items.create'))
            ->assertOk()
            ->assertSee('Formulir Laporan')
            ->assertSee('Barang Hilang');
    }

    public function test_it_stores_a_lost_item_report(): void
    {
        Storage::fake('public');

        $response = $this->post(route('lost-items.store'), [
            'item_name' => 'Dompet Hitam',
            'category' => 'Aksesori',
            'incident_date' => now()->toDateString(),
            'location' => 'Parkiran Rektorat',
            'description' => 'Dompet hitam berisi kartu identitas.',
            'photo' => UploadedFile::fake()->create('dompet.jpg', 100, 'image/jpeg'),
            'reporter_name' => 'Made Wijaya',
            'phone' => '081234567890',
        ]);

        $response->assertRedirect(route('lost-items.create'));

        $lostItem = LostItem::first();

        $this->assertNotNull($lostItem);
        $this->assertSame('Dompet Hitam', $lostItem->item_name);
        $this->assertSame('menunggu_verifikasi', $lostItem->status);

        Storage::disk('public')->assertExists($lostItem->photo_path);
    }

    public function test_it_validates_required_lost_item_fields(): void
    {
        $this->post(route('lost-items.store'), [])
            ->assertSessionHasErrors([
                'item_name',
                'category',
                'incident_date',
                'location',
                'description',
                'reporter_name',
                'phone',
            ]);
    }
}
