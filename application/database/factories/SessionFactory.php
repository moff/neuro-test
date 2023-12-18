<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'score' => 10,
            'score_normalized' => 10,
            'start_difficulty' => 1,
            'end_difficulty' => 10,
            'course_id' => Course::factory(),
            'user_id' => User::factory()
        ];
    }
}
