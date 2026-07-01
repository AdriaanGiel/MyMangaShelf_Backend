<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ScrapingScript extends Model
{
    use HasFactory;

    protected $fillable = ['file', 'scraping_type_id','provider_id'];

    public function scrapingType(): BelongsTo
    {
        return $this->belongsTo(ScrapingType::class);
    }

    public function providers(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
