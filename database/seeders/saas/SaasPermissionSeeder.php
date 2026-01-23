<?php

namespace Database\Seeders\saas;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
class SaasPermissionSeeder extends Seeder
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




        ];

        foreach ($permissions as $group => $items) {
            foreach ($items as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'group' => $group,
                ]);
            }
        }
    }
}