<?php

namespace App\Models\Tenant;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 * Tenant-scoped personal access token.
 * Uses tenant DB so token create/lookup both happen in the same database.
 */
class PersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $connection = 'tenant';

    /**
     * Resolve connection at runtime so tenant DB is used after tenant middleware runs.
     */
    public function getConnectionName(): ?string
    {
        return config('saas.current_tenant') ? 'tenant' : null;
    }


}