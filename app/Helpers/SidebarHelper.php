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

        $menu = [
            [
                'name' => 'Dashboard',
                'icon' => 'la la-dashboard',
                'url' => $isSaas
                    ? route('saas.dashboard')
                    : route('tenant.dashboard', ['tenant' => $tenant]),
                'permission' => null,
            ],

            [
                'name' => 'Users Management',
                'icon' => 'la la-keyboard-o',
                'url' => $isSaas
                    ? route('saas.users.index')
                    : route('tenant.users.index', ['tenant' => $tenant]),
                'permission' => 'users view',
            ],

            [
                'name' => 'Roles Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.roles.index')
                    : route('tenant.roles.index', ['tenant' => $tenant]),
                'permission' => 'roles view',
            ],

            [
                'name' => 'Permission Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.permissions.index')
                    : route('tenant.permissions.index', ['tenant' => $tenant]),
                'permission' => 'permissions view',
            ],

            [
                'name' => 'Department Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.departments.index')
                    : route('tenant.departments.index'),
                'permission' => 'departments view',
            ],

            [
                'name' => 'Designation Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.designations.index')
                    : route('tenant.designations.index'),
                'permission' => 'designations view',
            ],

            [
                'name' => 'Employee Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.employees.index')
                    : route('tenant.employees.index'),
                'permission' => 'employees view',
            ],
            [
                'name' => 'Employee Address Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.employeeAddress.index')
                    : route('tenant.employeeAddress.index'),
                'permission' => 'employeeAddress view',
            ],

            [
                'name' => 'Report Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.reports.index')
                    : route('tenant.reports.index'),
                'permission' => 'reports view',
            ],



            [
                'name' => 'Asset Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.asset_assigns.index')
                    : route('tenant.asset_assigns.index'),
                'permission' => 'asset_assigns view',
            ],

             [
                'name' => 'Asset Assign Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.assigns.index')
                    : route('tenant.assigns.index'),
                'permission' => 'assigns view',
            ],

            [
                'name' => 'Project Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.projects.index')
                    : route('tenant.projects.index'),
                'permission' => 'projects view',
            ],



            [
                'name' => 'Chat Management',
                'icon' => 'la la-th',
                'url' => $isSaas
                    ? route('saas.chat.index', $auth_id)
                    : route('tenant.chat.index', $auth_id),
                'permission' => $isSaas ? null : 'chat view',
            ],






        ];

        //  ONLY SAAS
        if ($isSaas) {
            $menu[] = [
                'name' => 'Tenant Management',
                'icon' => 'la la-th',
                'url' => route('saas.tenants.index'),
                'permission' => 'tenants view',
            ];
        }

        return $menu;
    }
}
