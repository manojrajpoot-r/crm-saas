<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Comment extends BaseTenantModel
{
    protected $fillable = ['comment','commentable_type','commentable_id', 'user_id'];

    public function commentable()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(TenantUser::class);
    }

    public function documents()
    {
        return $this->hasMany(CommentFile::class);
    }
}
