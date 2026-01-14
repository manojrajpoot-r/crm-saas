<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
 use Illuminate\Support\Facades\Log;
class TenantMiddleware
{
public function handle($request, Closure $next)
{
    $host = $request->getHost();
    $tenant = explode('.', $host)[0];

    if (in_array($tenant, ['crm', 'www', 'localhost'])) {
        config(['saas.current_tenant' => null]);
        return $next($request);
    }

    $db = 'tenant_' . $tenant;

    config(['database.connections.tenant.database' => $db]);

    DB::purge('tenant');
    DB::reconnect('tenant');

    //  Store tenant globally
    config(['saas.current_tenant' => $tenant]);

    return $next($request);
}


// public function handle($request, Closure $next)
// {
//     $host = $request->getHost(); // google.local
//     $tenant = explode('.', $host)[0]; // google

//     if (in_array($tenant, ['crm', 'www', 'localhost'])) {
//         return $next($request);
//     }

//     $db = 'tenant_' . $tenant; // tenant_google

//     config(['database.connections.tenant.database' => $db]);

//     DB::purge('tenant');
//     DB::reconnect('tenant');

//     return $next($request);
// }






}