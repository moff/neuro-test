<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class SessionService
{
    public const SESSIONS_LIMIT = 12;

    /**
     * @param User $user
     * @return array
     */
    public function getHistory(User $user): array
    {
        return DB::select(
            'SELECT id, score, created_at FROM sessions WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :sessions_limit',
            [
                'user_id' => $user->id,
                'sessions_limit' => self::SESSIONS_LIMIT,
            ]
        );
    }

    /**
     * @param int $sessionId
     * @return array
     */
    public function getSessionExerciseCategories(int $sessionId): array
    {
        $sql = 'select distinct domain_categories.name
                from domain_categories
                inner join exercises e on domain_categories.id = e.category_id
                inner join exercise_session es on e.id = es.exercise_id
                where es.session_id = :session_id';

        $categories = DB::select(
            $sql,
            [
                'session_id' => $sessionId,
            ]
        );

        $names = [];

        foreach ($categories as $category) {
            $names[] = $category->name;
        }

        return $names;
    }
}
