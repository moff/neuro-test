<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Session;
use App\Models\User;
use App\Services\SessionService;
use Tests\WebTestCase;

class SessionServiceTest extends WebTestCase
{
    /**
     * @return void
     */
    public function test_get_history()
    {
        /** @var SessionService $sessionService */
        $sessionService = resolve(SessionService::class);

        $sessionsNum = 3;
        $user = User::factory()->create();

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

        $sessions = $sessionService->getHistory($user);

        $this->assertEquals($sessionsNum, count($sessions));
    }

    // TODO: tests for ordering/limit check
}
