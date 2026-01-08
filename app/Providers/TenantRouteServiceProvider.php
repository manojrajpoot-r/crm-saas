<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TenantRouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {



     Route::macro('moduleCRUD', function ($moduleName, $controllerClass, $prefix) {
    Route::prefix($prefix)
        ->name($prefix . '.')
        ->group(function () use ($moduleName, $controllerClass) {
            Route::get('/', [$controllerClass, 'index'])->name('index');
            Route::get('/list', [$controllerClass, 'list'])->name('list');
            Route::post('/store', [$controllerClass, 'store'])->name('store');
            Route::get('/edit/{id?}', [$controllerClass, 'edit'])->name('edit');
            Route::post('/update/{id}', [$controllerClass, 'update'])->name('update');
            Route::post('/delete/{id}', [$controllerClass, 'delete'])->name('delete');
            Route::post('/status/{id}', [$controllerClass, 'status'])->name('status');
            Route::get('/show/{id}', [$controllerClass, 'show'])->name('show');
            Route::post('/password-change/{id}', [$controllerClass, 'changePassword'])->name('password.change');

        });
});



        Route::middleware(['web', 'tenant'])
            ->group(base_path('routes/tenant.php'));
    }
}