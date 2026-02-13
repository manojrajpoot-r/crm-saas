<?php

namespace App\Http\Controllers\API\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Http\Resources\AttendanceCollection;

class AttendanceController extends Controller
{
    protected $service;

    public function __construct(AttendanceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->list(20);
        return new AttendanceCollection($data);
    }

    public function store(AttendanceRequest $request)
    {
        $data = $this->service->store($request->validated());
        return new AttendanceResource($data);
    }

    public function checkOut(Request $request)
    {
        $data = $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $attendance = $this->service->checkOut($data);

        return new AttendanceResource($attendance);
    }


    public function show($id)
    {
        $data = $this->service->show($id);
        return new AttendanceResource($data);
    }

    public function update(AttendanceRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());
        return new AttendanceResource($data);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
