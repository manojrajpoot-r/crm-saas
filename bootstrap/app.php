<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TenantAuthMiddleware;
use App\Http\Middleware\TenantMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withProviders([
        App\Providers\TenantRouteServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware) {

        // ✅ FIX 1: CSRF EXCEPTION (AJAX LOGIN)
        $middleware->validateCsrfTokens(except: [
            'tenant/login',
            'tenant/login/*',
        ]);

        // ✅ FIX 2: ALIASES
        $middleware->alias([
            'tenant-auth' => TenantAuthMiddleware::class,
            'tenant'      => TenantMiddleware::class,
        ]);

        // ✅ FIX 3 (MOST IMPORTANT):
        // Tenant DB MUST be set BEFORE auth/session
        $middleware->prependToGroup('web', [
            TenantMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
