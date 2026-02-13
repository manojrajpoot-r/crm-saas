<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\TenantUser;
class UserShift extends Model
{


    public function user()
    {
        return $this->belongsTo(TenantUser::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

}
