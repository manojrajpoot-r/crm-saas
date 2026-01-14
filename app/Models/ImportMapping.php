<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportMapping extends Model
{
    protected $fillable = [
        'import_id','excel_column','db_field'
    ];

    public function import()
    {
        return $this->belongsTo(Import::class);
    }
}
