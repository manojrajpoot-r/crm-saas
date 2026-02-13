<?php
namespace App\Repositories;

use App\Models\Tenant\TenantUser;

class UserRepository
{
    public function findByEmail($email)
    {
        return TenantUser::where('email', $email)->first();
    }
}