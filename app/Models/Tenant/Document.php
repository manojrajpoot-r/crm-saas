<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Document extends BaseTenantModel
{
    protected $fillable = [
        'documentable_id',
        'documentable_type',
        'file_path',
        'uploaded_by',
    ];

    protected static function booted()
    {
        static::creating(function ($doc) {
            if (Auth::check() && empty($doc->uploaded_by)) {
                $doc->uploaded_by = Auth::id();
            }
        });
    }

    public function documentable()
    {
        return $this->morphTo();
    }

 public function uploadedBy()
{
    return $this->belongsTo(TenantUser::class, 'uploaded_by');
}

}
