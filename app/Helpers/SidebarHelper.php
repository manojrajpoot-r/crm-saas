<?php

namespace App\Helpers;

class SidebarHelper
{
    public static function menu(): array
    {
        $isSaas = isSaas();

        $menus = [

            self::item(
                'Dashboard',
                'la la-house-damage',
                tenantRoute('dashboard', 'saas.dashboard.index')
            ),

            self::dropdown('User Management', 'la la-users-cog', [

                self::item(
                    'Users',
                    'la la-user',
                    tenantRoute('users.index', 'saas.users.index'),
                    'view_users'
                ),
                self::item(
                    'Roles',
                    'la la-user-shield',
                    tenantRoute('roles.index', 'saas.roles.index'),
                    'view_roles'
                ),

                self::item(
                    'Permissions',
                    'la la-key',
                    tenantRoute('permissions.index', 'saas.permissions.index'),
                    'view_permissions'
                ),

            ]),

            !$isSaas ? self::dropdown('HR Management', 'la la-id-card', [

                self::item('Departments', 'la la-sitemap', tenantRoute('departments.index'), 'view_hrs'),
                self::item('Designations', 'la la-user-tag', tenantRoute('designations.index'), 'view_hrs'),
                self::item('Employees', 'la la-users', tenantRoute('employees.index'), 'view_hrs'),
                 self::item('Assigned', 'la la-users', tenantRoute('assigns.index'), 'view_hrs'),
                 self::item('Assets', 'la la-users', tenantRoute('asset_assigns.index'), 'view_hrs'),

            ]) : null,

            !$isSaas ? self::item(
                'Projects',
                'la la-project-diagram',
                tenantRoute('projects.index'),
                'view_projects'
            ) : null,

            !$isSaas ? self::dropdown('Leave Management', 'la la-calendar', [

                self::item('Leave Types', 'la la-calendar-check', tenantRoute('leaveTypes.index'), 'view_leave_types'),
                self::item('Leaves', 'la la-calendar-times', tenantRoute('leaves.index'), 'view_leaves'),
                self::item('Holidays', 'la la-calendar-times', tenantRoute('holidays.index'), 'view_holidays'),
                 self::item('Calendars', 'la la-calendar-times', tenantRoute('calendars.index'), 'view_calendars'),

            ]) : null,

            self::item(
                'Import',
                'la la-file-import',
                tenantRoute('import.index', 'saas.import.index'),
                'view_imports'
            ),

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
    if (!$url || !is_string($url)) {
        return null;
    }

    return compact('name', 'icon', 'url', 'permission');
}


    private static function dropdown($name, $icon, $submenu, $permission = null)
    {
        $submenu = array_values(array_filter($submenu));
        if (empty($submenu)) return null;
        return compact('name', 'icon', 'submenu', 'permission');
    }
}