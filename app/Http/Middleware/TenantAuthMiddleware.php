<?php
namespace App\Http\Middleware;

use Closure;

class TenantAuthMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if (!canAccess($permission)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }

}
