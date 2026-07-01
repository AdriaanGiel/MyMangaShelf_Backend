<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReadingSpot>
 */
class ReadingSpotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'media_id' => Media::factory(),
            'location' => fake()->address(),
            'image' => fake()->imageUrl(400, 300),
            'user_id' => User::factory(),
        ];
    }
}
