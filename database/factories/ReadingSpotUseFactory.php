<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\ReadingSpot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReadingSpotUse>
 */
class ReadingSpotUseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'reading_spot_id' => ReadingSpot::factory(),
            'media_id' => Media::factory(),
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
}
