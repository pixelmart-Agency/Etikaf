<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionsCheck
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $routeName = $request->route()->getName();
        $user = auth()->user();
        if (!$user->hasPermissionTo($routeName)) {
            return redirect()->route('root');
        }
        return $next($request);
    }
}
