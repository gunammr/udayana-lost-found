<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
])]
class FoundItem extends Model
{
    /** @use HasFactory<\Database\Factories\FoundItemFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'incident_date' => 'date',
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
}
