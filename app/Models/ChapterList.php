<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChapterList extends Model
{
    use HasFactory;

    protected $table = 'chapter_lists';
    protected $fillable = ['name','chapter', 'media_provider_id'];

    public function mediaProvider(): BelongsTo
    {
        return $this->belongsTo(MediaProvider::class);
    }

    public function mediaProviderChapterLists(): BelongsToMany
    {
        return $this->belongsToMany(MediaProvider::class, 'media_provider_chapter_list');
    }
}
