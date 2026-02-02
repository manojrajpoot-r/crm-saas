<?php

use Illuminate\Support\Facades\Request;

function isSaas(): bool
{
    return Request::routeIs('saas.*');
}

function currentTenant()
{
    return config('saas.current_tenant');
}

// function tenantRoute(string $tenantRoute, string $saasRoute = null, array $params = [])
// {

//     if (isSaas()) {
//         return $saasRoute
//             ? route($saasRoute, $params)
//             : '#';
//     }

//     $tenant = currentTenant();

//     if (!$tenant) {
//         return '#';
//     }

//     return route(
//         'tenant.' . $tenantRoute,
//         array_merge(['tenant' => $tenant->id], $params)
//     );
// }
function tenantRoute(string $tenantRoute, string $saasRoute = null, $param = null)
{
    if (isSaas()) {
        return $saasRoute
            ? route($saasRoute, is_array($param) ? $param : ($param ? ['id' => $param] : []))
            : '#';
    }

    if (!currentTenant()) return '#';

    return route(
        'tenant.' . $tenantRoute,
        is_array($param) ? $param : ($param ? ['id' => $param] : [])
    );
}
