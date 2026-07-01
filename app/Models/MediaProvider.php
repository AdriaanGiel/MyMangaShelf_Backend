<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaProvider extends Model
{
    use HasFactory;

    protected $table = 'media_provider';
    protected $fillable = ['media_id', 'provider_id'];

    public function chapterList()
    {
        return $this->HasMany(ChapterList::class, "media_provider_id");
    }
}
