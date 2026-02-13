<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class TenantRouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {



        /**
         *  MODULE CRUD MACRO
         */
        // Route::macro('moduleCRUD', function ($moduleName, $controllerClass, $prefix) {
        //     Route::prefix($prefix)
        //         ->name($prefix . '.')
        //         ->group(function () use ($controllerClass) {

        //             Route::get('/', [$controllerClass, 'index'])->name('index');
        //             Route::get('/list', [$controllerClass, 'list'])->name('list');

        //             Route::post('/store', [$controllerClass, 'store'])->name('store');
        //             Route::get('/edit/{id?}', [$controllerClass, 'edit'])->name('edit');
        //             Route::post('/update/{id}', [$controllerClass, 'update'])->name('update');
        //             Route::post('/delete/{id}', [$controllerClass, 'delete'])->name('delete');

        //             Route::post('/status/{id}', [$controllerClass, 'status'])->name('status');
        //             Route::get('/show/{id}', [$controllerClass, 'show'])->name('show');

        //             Route::post('/password-change/{id}', [$controllerClass, 'changePassword'])
        //                 ->name('password.change');
        //         });
        // });



        Route::macro('moduleCRUD', function ($name, $controller, $route) {

            Route::middleware("permission:view_$route")->group(function () use ($controller, $route) {
                Route::get($route, [$controller, 'index'])->name("$route.index");
                Route::get("$route/show/{id}", [$controller, 'show'])->name("$route.show");
            });

            Route::middleware("permission:create_$route")->group(function () use ($controller, $route) {
                Route::get("$route/create", [$controller, 'create'])->name("$route.create");
                Route::post("$route/store", [$controller, 'store'])->name("$route.store");
            });

            Route::middleware("permission:edit_$route")->group(function () use ($controller, $route) {
                Route::get("$route/edit/{id?}", [$controller, 'edit'])->name("$route.edit");
                Route::post("$route/update/{id}", [$controller, 'update'])->name("$route.update");
            });
             Route::middleware("permission:status_$route")->group(function () use ($controller, $route) {
                Route::post("$route/status/{id}", [$controller, 'status'])->name("$route.status");
            });

            Route::middleware("permission:delete_$route")->group(function () use ($controller, $route) {
                Route::post("$route/delete/{id}", [$controller, 'delete'])->name("$route.delete");
            });

            Route::middleware("permission:changePassword_$route")->group(function () use ($controller, $route) {
                Route::post("$route/password-change/{id}", [$controller, 'changePassword'])->name("$route.password.change");
            });


        });


        /**
         *  TENANT ROUTES LOAD
         */
        Route::middleware(['web', 'tenant'])
            ->group(base_path('routes/tenant.php'));

    }
}