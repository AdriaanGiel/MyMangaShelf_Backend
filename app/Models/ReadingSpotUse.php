<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadingSpotUse extends Model
{
    use HasFactory;

    protected $table = 'reading_spots_uses';
    protected $fillable = ['user_id', 'reading_spot_id', 'media_id', 'rating'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function readingSpot(): BelongsTo
    {
        return $this->belongsTo(ReadingSpot::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
