<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class CommentFile extends BaseTenantModel
{
    protected $fillable = ['file', 'comment_id'];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
