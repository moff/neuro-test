<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\SessionResource;
use App\Services\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SessionsHistoryController extends Controller
{
    /**
     * In the test task description there is REST resource mentioned, but I went with single action controller
     * Because I'm going to have only one endpoint for this task
     *
     * @param Request $request
     * @param SessionService $sessionService
     * @return JsonResponse
     */
    public function __invoke(
        Request $request,
        SessionService $sessionService
    ): JsonResponse {
        // this service expects User object, so this endpoint should be auth guarded
        $sessions = $sessionService->getHistory($request->user());

        // here we need a layer of checks that we really have an ID, but in context of test task it's not necessary
        $lastTrainedCategories = $sessionService->getSessionExerciseCategories($sessions[0]->id);

        return response()->json((object) [
            'history' => SessionResource::collection($sessions),
            'last_trained_categories' => collect($lastTrainedCategories)->join(', '),
        ]);
    }
}
