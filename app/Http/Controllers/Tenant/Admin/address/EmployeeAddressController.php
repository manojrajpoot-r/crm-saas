<?php

namespace App\Http\Controllers\Tenant\Admin\address;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\EmployeeAddress;
use App\Traits\UniversalCrud;
class EmployeeAddressController extends Controller
{
      use UniversalCrud;

    public function index()
    {
        return view('tenant.admin.address.index');
    }

    public function list()
    {
        $query = EmployeeAddress::with('employee')->latest();

        return datatables()->of($query)
            ->addIndexColumn()

            ->addColumn('employee_name', function ($t) {
                return $t->employee
                    ? $t->employee->first_name . ' ' . $t->employee->last_name
                    : '-';
            })

            ->addColumn('present_address_full', function ($t) {
                return trim(
                    $t->present_address . ', ' .
                    $t->present_landmark . ', ' .
                    $t->present_city . ', ' .
                    $t->present_state . ', ' .
                    $t->present_country . ' - ' .
                    $t->present_zipcode
                , ', ');
            })

            ->addColumn('permanent_address_full', function ($t) {
                return trim(
                    $t->permanent_address . ', ' .
                    $t->permanent_landmark . ', ' .
                    $t->permanent_city . ', ' .
                    $t->permanent_state . ', ' .
                    $t->permanent_country . ' - ' .
                    $t->permanent_zipcode
                , ', ');
            })

            // ->addColumn('status_btn', function ($t) {
            //     if (!canAccess('employeeAddresss status')) {
            //         return '-';
            //     }

            //     $class = $t->status ? "btn-success" : "btn-danger";
            //     $text  = $t->status ? "Active" : "Inactive";
            //     $url   = route('tenant.employeeAddress.status', [
            //         'tenant' => currentTenant(),
            //         'id' => $t->id
            //     ]);

            //     return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
            // })

            // ->addColumn('action', function ($t) {
            //     $buttons = '';

            //     if (canAccess('employeeAddress edit')) {
            //         $editUrl = route('tenant.employeeAddress.edit', [
            //             'tenant' => currentTenant(),
            //             'id' => $t->id
            //         ]);
            //         $buttons .= "<button class='btn btn-info btn-sm editBtn' data-url='$editUrl'>Edit</button> ";
            //     }

            //     if (canAccess('employeeAddress delete')) {
            //         $deleteUrl = route('tenant.employeeAddress.delete', [
            //             'tenant' => currentTenant(),
            //             'id' => $t->id
            //         ]);
            //         $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='$deleteUrl'>Delete</button> ";
            //     }

            //     return $buttons ?: '-';
            // })

            ->rawColumns(['status_btn', 'action'])
            ->make(true);
    }




     // ===============================
    // CREATE / STORE
    // ===============================

    public function store(Request $request)
    {
        return $this->saveData($request, EmployeeAddress::class);
    }


    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $t = EmployeeAddress::find($id);

        $json=[
            "name" => $t->name,

        ];
        return response()->json($json);
    }

    // ===============================
    // UPDATE
    // ===============================

    public function update(Request $request, $id)
    {
        return $this->saveData($request, EmployeeAddress::class, $id);
    }



    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        return $this->deleteData(EmployeeAddress::class,$id);
    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(EmployeeAddress::class, $id);
    }
}
