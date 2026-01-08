<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class PostDocument extends BaseTenantModel
{
     protected $fillable = [
        'post_id',
        'file',
        'original_name',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}