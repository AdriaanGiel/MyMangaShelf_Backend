<?php

namespace Database\Factories;

use App\Models\MediaProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChapterList>
 */
class ChapterListFactory extends Factory
{
    public function definition(): array
    {
        $mediaProvider = MediaProvider::inRandomOrder()->first();

        return [
            'chapter' => 'Chapter ' . fake()->numberBetween(1, 500),
            'media_provider_id' => $mediaProvider ? $mediaProvider->id : MediaProvider::factory(),
        ];
    }
}
