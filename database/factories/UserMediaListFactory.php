<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserMediaList>
 */
class UserMediaListFactory extends Factory
{
    public function definition(): array
    {
        $status = Status::inRandomOrder()->first();

        return [
            'user_id' => User::factory(),
            'media_id' => Media::factory(),
            'status_id' => $status ? $status->id : Status::factory(),
            'custom_status_id' => null,
        ];
    }
}
