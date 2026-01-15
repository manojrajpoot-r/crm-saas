<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SidebarHelper
{
    public static function fullMenu()
    {
        $auth_id = Auth::guard('web')->id();
        $isSaas = Auth::guard('web')->check();
        $tenant = Request::route('tenant');

        return [

            [
                'name' => 'Dashboard',
               'icon' => 'la la-house-damage',
                'url' => $isSaas ? route('saas.dashboard.index') : route('tenant.dashboard', ['tenant' => $tenant]),
                'permission' => null,
            ],

            [
                'name' => 'User Management',
                'icon' => 'la la-users-cog',
                'submenu' => [
                    [
                        'name' => 'Users',
                        'url' => $isSaas ? route('saas.users.index') : route('tenant.users.index', ['tenant' => $tenant]),
                        'permission' => 'users view',
                    ],
                    [
                        'name' => 'Roles',
                        'url' => $isSaas ? route('saas.roles.index') : route('tenant.roles.index', ['tenant' => $tenant]),
                        'permission' => 'roles view',
                    ],
                    [
                        'name' => 'Permissions',
                        'url' => $isSaas ? route('saas.permissions.index') : route('tenant.permissions.index', ['tenant' => $tenant]),
                        'permission' => 'permissions view',
                    ],
                ],
            ],

            !$isSaas ? [
                'name' => 'HR Management',
                'icon' => 'la la-id-card',
                'submenu' => [
                    [
                        'name' => 'Departments',
                        'url' => route('tenant.departments.index'),
                        'permission' => 'departments view',
                    ],
                    [
                        'name' => 'Designations',
                        'url' =>  route('tenant.designations.index'),
                        'permission' => 'designations view',
                    ],
                    [
                        'name' => 'Employees',
                        'url' => route('tenant.employees.index'),
                        'permission' => 'employees view',
                    ],
                    [
                        'name' => 'Employee Address',
                        'url' =>  route('tenant.employeeAddress.index'),
                        'permission' => 'employeeAddress view',
                    ],
                ],
            ] :null,

            !$isSaas ?  [
                'name' => 'Asset Management',
                'icon' => 'la la-box',
                'submenu' => [
                    [
                        'name' => 'Assets',
                        'url' => route('tenant.asset_assigns.index'),
                        'permission' => 'asset_assigns view',
                    ],
                    [
                        'name' => 'Asset Assign',
                        'url' => route('tenant.assigns.index'),
                        'permission' => 'assigns view',
                    ],
                ],
            ] :null,

            !$isSaas ? [
                'name' => 'Projects',
                'icon' => 'la la-project-diagram',
                'url' =>  route('tenant.projects.index'),
                'permission' => 'projects view',
            ]:null,

          !$isSaas ? [
            'name' => 'Reports',
            'icon' => 'la la-chart-bar',
            'url' => route('tenant.reports.index'),
            'permission' => 'reports view',
        ] : null,

            [
                'name' => 'Import',
                'icon' => 'la la-file-import',
                'url' => $isSaas ? route('saas.import.index') : route('tenant.import.index'),
                'permission' => $isSaas ? null : 'import view',
            ],

            $isSaas ? [
                'name' => 'Chat',
               'icon' => 'la la-comment',
                'url' => route('saas.chat.index', $auth_id),
                'permission' => $isSaas ? null : 'chat view',
            ]: null,

            $isSaas ? [
                'name' => 'Tenant Management',
                'icon' => 'la la-city',
                'url' => route('saas.tenants.index'),
                'permission' => 'tenants view',
            ] : null,
        ];
    }
}
