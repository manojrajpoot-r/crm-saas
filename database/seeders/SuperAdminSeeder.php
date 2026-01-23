<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
         Role::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Super Admin',
            ]
        );
        User::updateOrCreate(
            ['email' => 'admin@crm.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123456'),
                'role_id' => 1,
            ]
        );
    }
}
