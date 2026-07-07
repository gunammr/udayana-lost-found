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

    public function categoryData(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
