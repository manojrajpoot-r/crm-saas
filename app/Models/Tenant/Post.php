<?php

namespace App\Models\Tenant;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Comment;
class Post extends BaseTenantModel
{

    protected $fillable = ['name','description','uploaded_by','project_id'];
    public function documents()
    {
        return $this->hasMany(PostDocument::class);
    }

    public function uploader()
    {
        return $this->belongsTo(TenantUser::class, 'uploaded_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable_id');
    }

}
