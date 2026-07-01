<?php

namespace Database\Factories;

use App\Models\ScrapingType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScrapingScript>
 */
class ScrapingScriptFactory extends Factory
{
    public function definition(): array
    {
        $scrapingType = ScrapingType::inRandomOrder()->first();

        return [
            'file' => fake()->word() . '.js',
            'scraping_type_id' => $scrapingType ? $scrapingType->id : ScrapingType::factory(),
        ];
    }
}
