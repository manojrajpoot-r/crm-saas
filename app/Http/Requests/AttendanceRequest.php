<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i:s',
            'check_out' => 'nullable|date_format:H:i:s',
            'status' => 'required|string',

            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',

            'shift_id' => 'nullable|integer',
            'late_mark' => 'nullable|boolean',
            'overtime_hours' => 'nullable|numeric'
        ];
    }
}
