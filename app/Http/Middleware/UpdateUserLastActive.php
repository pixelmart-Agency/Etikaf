<?php

namespace App\Http\Middleware;

use App\Models\RetreatMosqueLocation;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UpdateUserLastActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if current season is available
        $currentSeason = currentSeason();
        if (!$currentSeason) {
            Log::info('Current season is not available.');
            $updatedCount = RetreatMosqueLocation::query()->update(['avg_requests' => 0]);
            Log::info("Updated {$updatedCount} records in RetreatMosqueLocation.");
        }

        // Delete users with null names
        $users = User::whereNull('name')->get();
        if ($users->count()) {
            Log::info("Found {$users->count()} users with null name.");
            $users->each(function ($user) {
                Log::info("Deleting user with ID: {$user->id}");
                $user->delete();
            });
        }

        // Update last_active_at for the authenticated user
        $user = Auth::user();
        if ($user) {
            $user->update(['last_active_at' => now()]);
            Log::info("Updated last_active_at for user ID: {$user->id}");
        } else {
            Log::warning("No authenticated user found.");
        }

        return $next($request);
    }
}
