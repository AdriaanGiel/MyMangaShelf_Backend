<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScrapingType>
 */
class ScrapingTypeFactory extends Factory
{
    public function definition(): array
    {
        $types = ['search', 'latest', 'chapterlist', 'detail'];

        return [
            'name' => fake()->randomElement($types),
        ];
    }
}
