<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RedirectIfUnauthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() && ! $request->expectsJson()) {

            if (
                $request->routeIs('saas.*') ||
                $request->getHost() === 'crm.saas.local'
            ) {
                return redirect()->route('saas.web.login');
            }

            return redirect()->route('tenant.login');
        }

        return $next($request);
    }
}
