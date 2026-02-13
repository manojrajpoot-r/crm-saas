<?php

namespace App\Http\Controllers\API\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Shift;

class ShiftController extends Controller
{

    public function index(Request $request)
    {
        $shifts = Shift::all();
        return response()->json($shifts);
    }


    public function store(Request $request)
    {
        $shift = Shift::create($request->all());
        return response()->json($shift);
    }
    public function show($id)
    {
        $shift = Shift::find($id);
        return response()->json($shift);
    }
    public function update(Request $request, $id)
    {
        $shift = Shift::find($id);
        $shift->update($request->all());
        return response()->json($shift);
    }
    public function destroy($id)
    {
        $shift = Shift::find($id);
        $shift->delete();
        return response()->json(['message' => 'Shift deleted successfully']);
    }
}
