<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReadingSpot extends Model
{
    use HasFactory;

    protected $table = 'reading_spots';
    protected $fillable = ['name', 'media_id', 'location', 'image', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function readingSpotUses(): HasMany
    {
        return $this->hasMany(ReadingSpotUse::class);
    }
}
