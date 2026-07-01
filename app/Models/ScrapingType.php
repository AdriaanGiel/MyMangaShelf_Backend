<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScrapingType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function scrapingScripts(): HasMany
    {
        return $this->hasMany(ScrapingScript::class);
    }
}
