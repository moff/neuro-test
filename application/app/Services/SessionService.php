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
            'SELECT score, created_at FROM sessions WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :sessions_limit',
            [
                'user_id' => $user->id,
                'sessions_limit' => self::SESSIONS_LIMIT,
            ]
        );
    }
}
