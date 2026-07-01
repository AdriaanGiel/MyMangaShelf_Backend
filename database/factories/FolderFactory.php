<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Folder>
 */
class FolderFactory extends Factory
{
    public function definition(): array
    {
        $defaultFolders = ['Reading', 'Wishlist', 'Completed', 'Favorites', 'Archive'];

        return [
            'name' => fake()->randomElement($defaultFolders),
        ];
    }
}
