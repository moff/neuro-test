<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\Exercise;
use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $exercises = Exercise::factory()
            ->count(5)
            ->create([
                'course_id' => $course->id,
            ]);

        $session = Session::factory()->create([
            'course_id' => $course->id,
            'user_id' => $user->id,
        ]);

        DB::insert(
            'INSERT INTO exercise_session (exercise_id, session_id) VALUES (:exercise_id, :session_id)',
            [
                'exercise_id' => $exercises->first()->id,
                'session_id' => $session->id,
            ]
        );
    }
}
