<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
