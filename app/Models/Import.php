<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Import extends Model
{
    protected $fillable = [
        'user_id','file','total_rows','processed_rows','status','duplicate_action'
    ];

    // Relation with mapping
    public function mappings()
    {
        return $this->hasMany(ImportMapping::class);
    }

    // Relation with failed rows
    public function failedRows()
    {
        return $this->hasMany(ImportFailedRow::class);
    }
}
