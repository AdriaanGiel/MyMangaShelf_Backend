<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'published_year', 'cover', 'volumes', 'media_type_id'];

    public function type()
    {
        return $this->belongsTo(MediaType::class, 'media_type_id');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'media_author');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'media_tag');
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'media_provider')->withPivot('media_uri');
    }

    public function userMediaItems()
    {
        return $this->hasMany(UserMediaList::class);
    }

    public function readingHistory()
    {
        return $this->hasMany(ReadingHistory::class);
    }

}
