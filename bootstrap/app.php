<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TenantAuthMiddleware;
use App\Http\Middleware\TenantMiddleware;
use App\Http\Middleware\RedirectIfUnauthenticated;
use App\Http\Middleware\TenantMailConfig;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withProviders([
        App\Providers\TenantRouteServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware) {

       $middleware->redirectGuestsTo(fn () =>
        isSaas()
            ? route('saas.web.login')
            : route('tenant.login', ['tenant' => currentTenant()])
        );
        $middleware->validateCsrfTokens(except: [
            'tenant/login',
            'tenant/login/*',
        ]);

        $middleware->alias([
            'permission' => TenantAuthMiddleware::class,
            'tenant'      => TenantMiddleware::class,
            'auth.smart' => RedirectIfUnauthenticated::class,
            'tenant.mail' => TenantMailConfig::class,
        ]);


        $middleware->prependToGroup('web', [
            TenantMiddleware::class,
        ]);

        // Tenant must run first on API so token lookup uses tenant DB
        $middleware->prependToGroup('api', [
            TenantMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();