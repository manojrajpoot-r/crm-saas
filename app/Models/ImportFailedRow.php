<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportFailedRow extends Model
{
    protected $fillable = [
        'import_id','row_number','row_data','error'
    ];

    public function import()
    {
        return $this->belongsTo(Import::class);
    }
}