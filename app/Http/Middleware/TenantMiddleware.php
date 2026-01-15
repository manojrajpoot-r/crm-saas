<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Models\Tenant;
use App\Models\Domain;
class TenantMiddleware
{
public function handle($request, Closure $next)
{
    $host = $request->getHost();
    $subdomain = explode('.', $host)[0];

    // SaaS main domains skip
    if (in_array($subdomain, ['crm', 'www', 'localhost'])) {
        config(['saas.current_tenant' => null]);
        return $next($request);
    }

    // Domain check
    $domain = Domain::where('domain', $host)->first();

    if (!$domain || !$domain->is_active) {
        abort(403, 'Tenant disabled');
    }

    // Tenant check
    $tenant = Tenant::where('id', $domain->tenant_id)
                    ->where('status', 1)
                    ->first();

    if (!$tenant) {
        abort(403, 'Tenant inactive');
    }

    // Connect correct database
    $db = $tenant->database;   // tenant_google

    config(['database.connections.tenant.database' => $db]);
    DB::purge('tenant');
    DB::reconnect('tenant');

    // Store current tenant globally
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
