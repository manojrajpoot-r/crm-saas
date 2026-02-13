<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;


class AttendanceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'total_records' => $this->collection->count(),
            'present_count' => $this->collection->where('status', 'present')->count(),
            'absent_count' => $this->collection->where('status', 'absent')->count(),
            'data' => AttendanceResource::collection($this->collection),
        ];
    }
}
