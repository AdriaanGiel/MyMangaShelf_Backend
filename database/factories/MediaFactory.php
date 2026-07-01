<?php

namespace Database\Factories;

use App\Models\MediaType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    public function definition(): array
    {
        $mediaType = MediaType::inRandomOrder()->first();

        return [
            'title' => fake()->unique()->sentence(3),
            'description' => fake()->paragraph(),
            'published_year' => fake()->year(),
            'cover' => fake()->imageUrl(640, 480, 'anime'),
            'volumes' => fake()->numberBetween(1, 50),
            'media_type_id' => $mediaType ? $mediaType->id : MediaType::factory(),
        ];
    }
}
