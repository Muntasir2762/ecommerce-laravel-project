<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if(!Auth::check()){
            return redirect('/');
        }

        $authUser = Auth::user();

        if(!in_array($authUser->role, $roles)){
            abort(403, 'Access Denined');
        }

        return $next($request);
    }
}
