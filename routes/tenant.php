<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\Auth\TenantAuthController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\Admin\TenantUserController;
use App\Http\Controllers\Tenant\Admin\RoleController;
use App\Http\Controllers\Tenant\Admin\PermissionController;
use App\Http\Controllers\Tenant\Admin\RolePermissionController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Tenant\Admin\department\DepartmentController;
use App\Http\Controllers\Tenant\Admin\designation\DesignationController;
use App\Http\Controllers\Tenant\Admin\Employee\EmployeeController;
use App\Http\Controllers\Tenant\Admin\address\EmployeeAddressController;
use App\Http\Controllers\Tenant\Admin\asset\AssetController;
use App\Http\Controllers\Tenant\Admin\assign\AssignedAssetController;
use App\Http\Controllers\Tenant\Admin\project\ProjectController;
use App\Http\Controllers\Tenant\Admin\module\ProjectModuleController;
use App\Http\Controllers\Tenant\Admin\task\TaskController;
use App\Http\Controllers\Tenant\Admin\post\PostController;
use App\Http\Controllers\Tenant\Admin\report\ReportController;
use App\Http\Controllers\Tenant\Admin\chat\ChatController;
use App\Http\Controllers\Tenant\Admin\comment\CommentController;
use App\Http\Controllers\Tenant\Admin\team\TeamController;
use App\Http\Controllers\Tenant\Admin\import\ImportController;
use App\Http\Controllers\Tenant\Admin\leave\LeaveController;
use App\Http\Controllers\Tenant\Admin\leaveType\LeaveTypeController;

        // Route::get('/login', [TenantAuthController::class, 'showLoginForm'])->name('login');

      // Route::post('/login', [TenantAuthController::class, 'login'])->name('login.submit');

        // Route::get('/register', [TenantAuthController::class, 'showRegisterForm'])->name('register');
        // Route::post('/register', [TenantAuthController::class, 'register'])->name('register.submit');

Route::prefix('{tenant}')
    ->name('tenant.')
    ->group(function () {

        Route::get('/login', [TenantAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [TenantAuthController::class, 'login'])->name('login.submit');

        Route::get('/register', [TenantAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [TenantAuthController::class, 'register'])->name('register.submit');

});




    Route::middleware(['tenant', 'auth:tenant'])
    ->name('tenant.')
    ->group(function () {

        Route::post('logout', [TenantAuthController::class, 'logout'])->name('logout');

        Route::get('/', [HomeController::class, 'index'])->name('index');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::moduleCRUD('Users', TenantUserController::class, 'users');
        Route::moduleCRUD('Roles', RoleController::class, 'roles');
        Route::moduleCRUD('Permissions', PermissionController::class, 'permissions');
        Route::moduleCRUD('Departments', DepartmentController::class, 'departments');
        Route::moduleCRUD('Designations', DesignationController::class, 'designations');
        Route::moduleCRUD('Employees', EmployeeController::class, 'employees');
        Route::moduleCRUD('EmployeeAddress', EmployeeAddressController::class, 'employeeAddress');
        Route::moduleCRUD('Reports', ReportController::class, 'reports');
        Route::moduleCRUD('Assets', AssetController::class, 'asset_assigns');
        Route::moduleCRUD('AssignedAssets', AssignedAssetController::class, 'assigns');
        Route::moduleCRUD('Projects', ProjectController::class, 'projects');
        Route::moduleCRUD('ProjectModules', ProjectModuleController::class, 'modules');
        Route::moduleCRUD('Tasks', TaskController::class, 'tasks');
        Route::moduleCRUD('Posts', PostController::class, 'posts');
        Route::moduleCRUD('Comments', CommentController::class, 'comments');
        Route::moduleCRUD('Teams', TeamController::class, 'teams');
        Route::moduleCRUD('Leaves', LeaveController::class, 'leaves');
        Route::moduleCRUD('LeaveTypes', LeaveTypeController::class, 'leaveTypes');


        Route::get('search-users', [TeamController::class, 'searchUsers'])->name('teams.searchUsers');
        Route::post('assign-team', [TeamController::class, 'assignTeam'])->name('teams.assign.emplyees');
        Route::get('reports/export', [ReportController::class, 'reportExport'])->name('reports.export');
        Route::get('zipcode/{zip}', [EmployeeController::class, 'zipcode']);
        Route::get('roles/{id}/permissions', [RolePermissionController::class, 'editPermission'])->name('roles.permissions');
        Route::post('roles/{id}/permissions', [RolePermissionController::class, 'updatePermissions'])->name('roles.permissions.update');
        Route::get('chat/{user?}', [ChatController::class, 'index'])->name('chat.index');
        Route::post('chat/send', [ChatController::class, 'send'])->name('chat.send');
        Route::get('import/users', [ImportController::class, 'import_page'])->name('import.users.index');
        Route::get('import', [ImportController::class, 'index'])->name('import.index');
        Route::post('upload', [ImportController::class, 'upload'])->name('import.upload');
        Route::get('imports', [ImportController::class, 'list'])->name('imports.list');
        Route::get('imports/status/{id}', [ImportController::class, 'status']);
        Route::post('imports/retry/{id}', [ImportController::class, 'retry']);



});