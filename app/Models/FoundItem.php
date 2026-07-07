<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Status alur: ditemukan → diklaim → dikembalikan → selesai
 */
#[Fillable([
    'user_id',
    'category_id',
    'lost_item_id',
    'item_name',
    'category',
    'incident_date',
    'location',
    'description',
    'photo_path',
    'reporter_name',
    'phone',
    'status',
    'diklaim_at',
    'dikembalikan_at',
    'selesai_at',
])]
class FoundItem extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'incident_date'   => 'date',
            'diklaim_at'      => 'datetime',
            'dikembalikan_at' => 'datetime',
            'selesai_at'      => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lostItem(): BelongsTo
    {
        return $this->belongsTo(LostItem::class);
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    /** Klaim yang sudah diterima/disetujui oleh admin */
    public function acceptedClaim(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        // Prioritaskan klaim dengan status 'diterima', fallback ke klaim terbaru
        return $this->hasOne(Claim::class)
            ->orderByRaw("CASE status WHEN 'diterima' THEN 1 WHEN 'menunggu' THEN 2 WHEN 'ditolak' THEN 3 ELSE 4 END")
            ->latest('updated_at');
    }

    public function categoryData(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
