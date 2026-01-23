<?php

namespace App\Models\Tenant;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Comment;
class Post extends BaseTenantModel
{

    protected $fillable = ['name','description','uploaded_by','project_id'];


    public function uploader()
    {
        return $this->belongsTo(TenantUser::class, 'uploaded_by');
    }



     public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }


}
