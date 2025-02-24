<?php

namespace App\Http\Middleware;

use App\Enums\UserTypesEnum;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEmployee
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
        if (Auth::user()->user_type == UserTypesEnum::EMPLOYEE->value) {
            return $next($request);
        }
        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    }
}
