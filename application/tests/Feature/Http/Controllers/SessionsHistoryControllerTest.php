<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Course;
use App\Models\DomainCategory;
use App\Models\Exercise;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\WebTestCase;

class SessionsHistoryControllerTest extends WebTestCase
{
    public function test_history_endpoint()
    {
        $sessionsNum = 3;
        $user = User::factory()->create();
        Auth::login($user);

        // create sessions that should be listed
        Session::factory()
            ->count($sessionsNum)
            ->create([
                'user_id' => $user->id,
            ]);

        // create sessions that should NOT be listed
        Session::factory()
            ->count($sessionsNum)
            ->create();

        // ! Instead of creating sample data, there is an option to mock sessions service
        $response = $this->getJson(route('sessions.history'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount($sessionsNum, 'history');
        $response->assertJsonStructure([
            'history' => [
                '*' => [
                    'score',
                    'date',
                ],
            ],
            'last_trained_categories',
        ]);
    }

    public function test_last_session_categories()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $course = Course::factory()->create();

        $testCategoryName = 'Test category';
        $category = DomainCategory::factory()->create([
            'name' => $testCategoryName,
        ]);

        $exercises = Exercise::factory()
            ->count(5)
            ->create([
                'course_id' => $course->id,
                'category_id' => $category->id,
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

        $response = $this->getJson(route('sessions.history'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'history' => [
                '*' => [
                    'score',
                    'date',
                ],
            ],
            'last_trained_categories',
        ]);
        $response->assertJsonPath('last_trained_categories', $testCategoryName);
    }
}
