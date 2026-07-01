<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'website', 'online'];

    public function media()
    {
        return $this->belongsToMany(Media::class, 'media_provider');
    }

    public function mediaProvider()
    {
        return $this->hasMany(MediaProvider::class, 'provider_id');
    }

    public function scrapingScripts()
    {
        return $this->hasMany(ScrapingScript::class);
    }
}
