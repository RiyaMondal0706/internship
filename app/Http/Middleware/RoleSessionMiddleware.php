<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleSessionMiddleware
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Check if session has user role
        if (!$request->session()->has('user_role')) {
            return redirect('/login');
        }

        if ($role && $request->session()->get('user_role') !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}