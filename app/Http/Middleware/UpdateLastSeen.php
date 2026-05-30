<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user() ?? null;
            if ($user && ($user->last_seen_at === null || $user->last_seen_at->lt(now()->subMinute()))) {
                $user->update(['last_seen_at' => now()]);
            }
        }

        return $next($request);
    }
}