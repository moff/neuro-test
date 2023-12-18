<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Course;
use App\Models\DomainCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'points' => 10,
            'category_id' => DomainCategory::factory(),
            'course_id' => Course::factory(),
        ];
    }
}
