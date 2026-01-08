<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
 use Illuminate\Support\Facades\Log;
class TenantMiddleware
{


    // public function handle($request, Closure $next)
    // {
    //     $host = $request->getHost();
    //     $parts = explode('.', $host);

    //     if (count($parts) < 3) {
    //         return $next($request);
    //     }

    //     $tenant = $parts[0];
    //     $dbName = 'tenant_' . $tenant;

    //     config(['database.connections.tenant.database' => $dbName]);

    //     DB::purge('tenant');
    //     DB::reconnect('tenant');

    //     Log::info('Tenant DB switched', [
    //         'host' => $host,
    //         'db' => DB::connection('tenant')->getDatabaseName()
    //     ]);

    //     return $next($request);
    // }



// public function handle($request, Closure $next)
// {
//     $host = $request->getHost(); // google.local
//     $tenant = explode('.', $host)[0];

//     // safety: CRM domain
//     if (in_array($tenant, ['crm', 'www', 'localhost'])) {
//         return $next($request);
//     }

//     $db = 'tenant_' . $tenant;

//     config(['database.connections.tenant.database' => $db]);

//     DB::purge('tenant');
//     DB::reconnect('tenant');

//     return $next($request);
// }

// public function handle($request, Closure $next)
// {
//     // tenant comes from URL: /tenant/{tenant}
//     $tenant = $request->route('tenant');

//     // safety
//     if (!$tenant) {
//         return $next($request);
//     }

//     $db = 'tenant_' . $tenant;

//     config(['database.connections.tenant.database' => $db]);

//     DB::purge('tenant');
//     DB::reconnect('tenant');

//     return $next($request);
// }


public function handle($request, Closure $next)
{
    $host = $request->getHost(); // google.local
    $tenant = explode('.', $host)[0]; // google

    if (in_array($tenant, ['crm', 'www', 'localhost'])) {
        return $next($request);
    }

    $db = 'tenant_' . $tenant; // tenant_google

    config(['database.connections.tenant.database' => $db]);

    DB::purge('tenant');
    DB::reconnect('tenant');

    return $next($request);
}






}