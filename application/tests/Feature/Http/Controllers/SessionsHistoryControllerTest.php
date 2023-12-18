<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
        ]);
    }
}
