<?php

namespace Database\Seeders\tenant;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use App\Models\Tenant\Permission;
class TenantPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $permissions = [

            'Users' => [
                'view_users',
                'create_users',
                'edit_users',
                'delete_users',
                'status_users',
                'export_reports',
                'import_reports',
                'change_users_password',
            ],

            'Roles' => [
                'view_roles',
                'create_roles',
                'edit_roles',
                'delete_roles',
                'status_roles',
                'assign_roles_permissions',

            ],

            'Permissions' => [
                'view_permissions',
                'create_permissions',
                'edit_permissions',
                'delete_roles',
                'status_permissions',
            ],


            'Reports' => [
                'view_reports',
                'export_reports',
            ],

            'Imports' => [
                'view_imports',
            ],

            'Tenants' => [
                'view_tenants',
                'create_tenants',
                'edit_tenants',
                'delete_tenants',
                'status_tenants',
            ],

            'Hrs' => [
            'view_hrs',
            'create_hrs',
            'edit_hrs',
            'delete_hrs',
            'status_hrs',
            ],

            'Assets' => [
            'view_assets',
            'create_assets',
            'edit_assets',
            'delete_assets',
            'status_assets',
            ],

            'Projects' => [
            'view_projects',
            'create_projects',
            'edit_projects',
            'delete_projects',
            'status_projects',
            ],

            'Projects' => [
            'view_projects',
            'create_projects',
            'edit_projects',
            'delete_projects',
            'status_projects',
            'details_view_projects',
            ],

            'Modules' => [
            'view_modules',
            'create_modules',
            'edit_modules',
            'delete_modules',
            'status_modules',
            ],

            'Tasks' => [
            'view_tasks',
            'create_tasks',
            'edit_tasks',
            'delete_tasks',
            'status_tasks',
            ],

            'Discussions' => [
            'view_discussions',
            'create_discussions',
            'edit_discussions',
            'delete_discussions',
            'status_discussions',
            ],

           'Comments' => [
            'view_comments',
            'create_comments',
            'edit_comments',
            'delete_comments',
            'status_comments',
            ],

            'Teams' => [
            'view_teams',
            'create_teams',
            ],




        ];

           foreach (Tenant::all() as $tenant) {

            // tenant database select manually
            config(['database.connections.tenant.database' => $tenant->database]);

            DB::purge('tenant');
            DB::reconnect('tenant');

            foreach ($permissions as $group => $items) {
                foreach ($items as $permission) {
                    Permission::firstOrCreate([
                        'name'       => $permission,
                        'group'      => $group,
                    ]);
                }
            }
        }
    }

}
