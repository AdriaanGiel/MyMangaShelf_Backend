<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    public function definition(): array
    {
        $defaults = ['Plan to Watch', 'Watching', 'Completed', 'On Hold', 'Dropped'];

        return [
            'name' => fake()->unique()->randomElement($defaults),
        ];
    }
}
