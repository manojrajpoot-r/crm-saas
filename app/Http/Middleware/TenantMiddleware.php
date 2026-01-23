<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use App\Models\Domain;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        // SaaS / main domains (no tenant)
        if (in_array($subdomain, ['crm', 'www', 'localhost'])) {
            config(['saas.current_tenant' => null]);
            return $next($request);
        }

        // Domain lookup
        $domain = Domain::where('domain', $host)->first();

        if (!$domain) {
            abort(404, 'Tenant domain not found.');
        }

        if (!$domain->is_active) {
            abort(403, 'This tenant is disabled.');
        }

        // Tenant lookup
        $tenant = Tenant::where('id', $domain->tenant_id)
            ->where('status', 1)
            ->first();

        if (!$tenant) {
            abort(403, 'Tenant inactive.');
        }

        // Switch database
        config([
            'database.connections.tenant.database' => $tenant->database
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');

        // Store tenant globally
        config(['saas.current_tenant' => $tenant]);

        return $next($request);
    }
}