<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Notification extends BaseTenantModel
{
     protected $fillable = [
        'user_id','title','message','meta','is_read'
    ];

      protected $casts = [
        'meta' => 'array'
    ];
}
