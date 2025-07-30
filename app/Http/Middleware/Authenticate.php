<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // ANCHOR: Check if session is expired and redirect with message
        if ($request->session()->has('errors')) {
            return route('login');
        }
        
        return $request->expectsJson() ? null : route('login');
    }
    
    /**
     * Handle an unauthenticated user.
     */
    protected function unauthenticated($request, array $guards)
    {
        // ANCHOR: Clear any expired session data
        if ($request->session()->isStarted()) {
            $request->session()->flush();
        }
        
        abort(401, 'Unauthenticated.');
    }
}
