<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantUserProvider implements UserProvider
{
    public function retrieveById($identifier): ?Authenticatable
    {
        $row = DB::connection('tenant')->table('users')->where('id', $identifier)->first();
        return $row ? new GenericUser((array) $row) : null;
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        $row = DB::connection('tenant')->table('users')
            ->where('id', $identifier)
            ->where('remember_token', $token)
            ->first();
        return $row ? new GenericUser((array) $row) : null;
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        DB::connection('tenant')->table('users')
            ->where('id', $user->getAuthIdentifier())
            ->update(['remember_token' => $token]);
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $query = DB::connection('tenant')->table('users');
        foreach ($credentials as $key => $value) {
            if ($key !== 'password') $query->where($key, $value);
        }
        $row = $query->first();
        return $row ? new GenericUser((array) $row) : null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return Hash::check($credentials['password'], $user->password);
    }



public function rehashPasswordIfRequired(
    Authenticatable $user,
    array $credentials,
    bool $force = false
): void {
    // अगर password field missing है तो कुछ मत करो
    if (!isset($credentials['password'])) {
        return;
    }

    $plainPassword = $credentials['password'];
    $hashedPassword = $user->password ?? null;

    if (!$hashedPassword) {
        return;
    }

    // Check if password needs rehash OR force=true
    if (\Illuminate\Support\Facades\Hash::needsRehash($hashedPassword) || $force) {

        $newHash = \Illuminate\Support\Facades\Hash::make($plainPassword);

        \Illuminate\Support\Facades\DB::connection('tenant')
            ->table('users')
            ->where('id', $user->getAuthIdentifier())
            ->update(['password' => $newHash]);
    }
}



}
