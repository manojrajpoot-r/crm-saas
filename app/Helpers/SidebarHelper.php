<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SidebarHelper
{
    public static function isSaas()
    {
        return Request::routeIs('saas.*');
    }

    public static function menu()
    {
        $isSaas = self::isSaas();
        $authId = Auth::id();

        $menus = [

            self::item(
                'Dashboard',
                'la la-house-damage',
                $isSaas
                    ? route('saas.dashboard.index')
                    : tenantRoute('dashboard')
            ),

            self::dropdown('User Management', 'la la-users-cog', [

                self::item(
                    'Users',
                    'la la-user',
                    $isSaas
                        ? route('saas.users.index')
                        : tenantRoute('users.index'),
                    'view_users'
                ),

                self::item(
                    'Roles',
                    'la la-user-shield',
                    $isSaas
                        ? route('saas.roles.index')
                        : tenantRoute('roles.index'),
                    'view_roles'
                ),

                self::item(
                    'Permissions',
                    'la la-key',
                    $isSaas
                        ? route('saas.permissions.index')
                        : tenantRoute('permissions.index'),
                    'view_permissions'
                ),

            ]),

            !$isSaas ? self::dropdown('HR Management', 'la la-id-card', [

                self::item(
                    'Departments',
                    'la la-sitemap',
                    tenantRoute('departments.index'),
                    'view_hrs'
                ),

                self::item(
                    'Designations',
                    'la la-user-tag',
                    tenantRoute('designations.index'),
                    'view_hrs'
                ),

                self::item(
                    'Employees',
                    'la la-users',
                    tenantRoute('employees.index'),
                    'view_hrs'
                ),

                self::item(
                    'Employee Address',
                    'la la-map-marker',
                    tenantRoute('employeeAddress.index'),
                    'view_hrs'
                ),

            ], 'view_hrs') : null,

            !$isSaas ? self::dropdown('Asset Management', 'la la-box', [

                self::item(
                    'Assets',
                    'la la-boxes',
                    tenantRoute('asset_assigns.index'),
                    'view_assets'
                ),

                self::item(
                    'Asset Assign',
                    'la la-clipboard-check',
                    tenantRoute('assigns.index'),
                    'view_assets'
                ),

            ], 'view_assets') : null,

            !$isSaas ? self::item(
                'Projects',
                'la la-project-diagram',
                tenantRoute('projects.index'),
                'view_projects'
            ) : null,


           self::dropdown('Leave Management', 'la la-users-cog', [
               !$isSaas ? self::item(
                    'Leave Types',
                    'la la-leave-diagram',
                    tenantRoute('leaveTypes.index'),
                    'view_leave_types'
                ) : null,
                !$isSaas ? self::item(
                    'Leave',
                    'la la-leave-diagram',
                    tenantRoute('leaves.index'),
                    'view_leaves'
                ) : null,


            ]),


            !$isSaas ? self::item(
                'Reports',
                'la la-chart-bar',
                tenantRoute('reports.index'),
                'view_reports'
            ) : null,

            self::item(
                'Import',
                'la la-file-import',
                $isSaas
                    ? route('saas.import.index')
                    : tenantRoute('import.index'),
                'view_imports'
            ),

            $isSaas ? self::item(
                'Chat',
                'la la-comment',
                route('saas.chat.index', $authId)
            ) : null,

            $isSaas ? self::item(
                'Tenant Management',
                'la la-city',
                route('saas.tenants.index'),
                'view_tenants'
            ) : null,
        ];

        return array_values(array_filter($menus));
    }

    private static function item($name, $icon, $url, $permission = null)
    {
        return compact('name', 'icon', 'url', 'permission');
    }

    private static function dropdown($name, $icon, $submenu, $permission = null)
    {
        return compact('name', 'icon', 'submenu', 'permission');
    }
}