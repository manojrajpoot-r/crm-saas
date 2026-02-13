<?php
namespace App\Repositories;

use App\Models\Tenant\Attendance;

class AttendanceRepository
{
    public function getAll($perPage = 20)
    {
        return Attendance::latest()->paginate($perPage);
    }

    public function findById($id)
    {
        return Attendance::findOrFail($id);
    }

    public function create(array $data)
    {
        return Attendance::create($data);
    }

    public function update($id, array $data)
    {
        $attendance = $this->findById($id);
        $attendance->update($data);
        return $attendance;
    }

    public function delete($id)
    {
        $attendance = $this->findById($id);
        return $attendance->delete();
    }
}
