<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Saas\Admin\SaasAuthController;
use App\Http\Controllers\Saas\Admin\SaasDashboardController;
use App\Http\Controllers\Saas\Admin\SaasUserController;
use App\Http\Controllers\Saas\Admin\SaasRoleController;
use App\Http\Controllers\Saas\Admin\SaasPermissionController;
use App\Http\Controllers\Saas\Admin\SaasRolePermissionController;
use App\Http\Controllers\Saas\Admin\SaasTenantCreateController;
use App\Http\Controllers\Saas\Admin\chat\ChatController;
use App\Http\Controllers\Saas\Admin\auth\TwoFactorController;
use App\Http\Controllers\Saas\Admin\import\ImportController;
use App\Http\Controllers\Front\face\FaceController;
use App\Http\Controllers\Front\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('index');
    // Route::get('/login', [HomeController::class, 'loginPage'])->name('login');
    // Route::post('/login', [HomeController::class, 'login'])->name('user.login.submit');

    // Route::get('/face-register', [FaceController::class, 'faceRegister'])->name('face.register');
    // Route::post('face-check-register', [FaceController::class, 'storeCameraRegister'])->name('face.store.register');

    // Route::get('/face-login', [FaceController::class, 'faceLoginPage'])->name('face.login');
    // Route::post('face-check-login', [FaceController::class, 'storeCameraLogin'])->name('face.store.login');
    // Route::get('facefetchdata', [FaceController::class, 'facefetchdata'])->name('face.fetch.data');


Route::domain('crm.saas.local')
    ->name('saas.')
    ->prefix('saas')
    ->group(function () {
    Route::get('/login', [SaasAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [SaasAuthController::class, 'login'])->name('login.submit');




    Route::get('/2fa', [TwoFactorController::class,'index'])->name('2fa.index');
    Route::post('/2fa/send', [TwoFactorController::class,'send']);
    Route::post('/2fa/verify', [TwoFactorController::class,'verify']);
    Route::post('/2fa/recovery', [TwoFactorController::class,'verifyRecoveryCode']);



    Route::middleware(['auth:web'])->group(function () {

            Route::get('/dashboard', [SaasDashboardController::class, 'index'])->name('dashboard.index');
            Route::post('/logout', [SaasAuthController::class, 'logout'])->name('logout');

            Route::moduleCRUD('Tenants', SaasTenantCreateController::class, 'tenants');
            Route::moduleCRUD('Users', SaasUserController::class, 'users');
            Route::moduleCRUD('Roles', SaasRoleController::class, 'roles');
            Route::moduleCRUD('Permissions', SaasPermissionController::class, 'permissions');





            Route::get('roles/{id}/permissions',[SaasRolePermissionController::class, 'editPermission'])->name('roles.permissions');
            Route::post('roles/{id}/permissions',[SaasRolePermissionController::class, 'updatePermissions'])->name('roles.permissions.update');

            Route::get('/chat/{user?}', [ChatController::class, 'index'])->name('chat.index');
            Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');


            Route::get('import/users', [ImportController::class,'import_page'])->name('import.users.index');
            Route::get('import', [ImportController::class,'index'])->name('import.index');
            Route::post('upload', [ImportController::class,'upload'])->name('import.upload');
            Route::get('imports', [ImportController::class,'list'])->name('imports.list');
            Route::get('imports/status/{id}', [ImportController::class,'status']);
            Route::post('imports/retry/{id}', [ImportController::class,'retry']);



        });

});