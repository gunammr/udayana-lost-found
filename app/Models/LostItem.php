<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Status alur: hilang → dicari → ditemukan → selesai
 */
#[Fillable([
    'user_id',
    'item_name',
    'category',
    'incident_date',
    'location',
    'description',
    'photo_path',
    'reporter_name',
    'phone',
    'status',
    'dicari_at',
    'ditemukan_at',
    'selesai_at',
])]
class LostItem extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'incident_date' => 'date',
            'dicari_at'     => 'datetime',
            'ditemukan_at'  => 'datetime',
            'selesai_at'    => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function foundReports(): HasMany
    {
        return $this->hasMany(FoundItem::class);
    }

    public function latestFoundReport(): HasOne
    {
        return $this->hasOne(FoundItem::class)->latestOfMany();
    }
}
