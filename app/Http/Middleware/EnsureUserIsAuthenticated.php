<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->has('user_id')) {
            return redirect('/login')->with('error', 'অনুগ্রহ করে আগে লগইন করুন।');
        }

        return $next($request);
    }
}
