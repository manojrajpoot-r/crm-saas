<?php

namespace App\Http\Controllers\Tenant\Admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Employee;
use App\Traits\UniversalCrud;
use App\Models\Tenant\Department;
use App\Models\Tenant\Designation;
use Illuminate\Support\Facades\Http;
use App\Models\Tenant\TenantUser;
class EmployeeController extends Controller
{
     use UniversalCrud;


    public function index(Request $request)
    {

        $employees = Employee::with(['user', 'department', 'designation', 'manager'])->latest()->paginate(10);

        if ($request->ajax()) {
            return view('tenant.admin.employees.table', compact('employees'))->render();
        }

        return view('tenant.admin.employees.index', compact('employees'));
    }

    // public function list()
    // {
    //     $query = Employee::with(['user', 'department', 'designation', 'manager'])->latest();

    //     return datatables()->of($query)
    //         ->addIndexColumn()

    //         ->addColumn('user_name', function ($t) {
    //             return $t->user ? $t->user->name : '-';
    //         })
    //         ->addColumn('department_name', function ($t) {
    //             return $t->department ? $t->department->name : '-';
    //         })
    //         ->addColumn('designation_name', function ($t) {
    //             return $t->designation ? $t->designation->name : '-';
    //         })
    //         ->addColumn('manager_name', function ($t) {
    //             return $t->manager ? $t->manager->first_name . ' ' . $t->manager->last_name : '-';
    //         })

    //          ->addColumn('dob', function($t){
    //                 return $this->formatDate($t->dob);
    //             })

    //          ->addColumn('join_date', function($t){
    //                 return $this->formatDate($t->join_date);
    //             })
    //         ->addColumn('status_btn', function ($t) {
    //             if (!canAccess('status_hrs')) {
    //                 return '-';
    //             }
    //             $class = $t->status ? "btn-success" : "btn-danger";
    //             $text  = $t->status ? "Active" : "Inactive";
    //             $url   = tenantRoute('employees.status', ['id' => $t->id]);

    //             return "<button class='btn btn-sm $class statusBtn' data-url='$url'>$text</button>";
    //         })
    //         ->addColumn('action', function ($t) {
    //             $buttons = '';
    //             if (canAccess('edit_hrs')) {
    //                 $editUrl = tenantRoute('employees.edit', ['id' => $t->id]);
    //                 $buttons .= "<a class='btn btn-info btn-sm' href='$editUrl'>Edit</a> ";
    //             }
    //             if (canAccess('delete_hrs')) {
    //                 $deleteUrl = tenantRoute('employees.delete', ['id' => $t->id]);
    //                 $buttons .= "<button class='btn btn-danger btn-sm deleteBtn' data-url='$deleteUrl'>Delete</button> ";
    //             }
    //             return $buttons ?: '-';
    //         })
    //         ->rawColumns(['status_btn', 'action'])
    //         ->make(true);
    // }




     // ===============================
    // CREATE / STORE
    // ===============================

   public function edit($id = null)
{
    $employee = $id
        ? Employee::with([
            'address',
            'personalInfo',
            'emergencyContacts',
            'familyInfos',
            'bankInfo',
            'upiInfo',
            'educations',
            'experiences',

        ])->findOrFail($id)
        : null;

    $departments  = Department::where('status','1')->select('id', 'name')->get();
    $designations = Designation::where('status','1')->select('id', 'name')->get();

    $managers = Employee::select('id', 'first_name', 'last_name')
        ->when($id, fn ($q) => $q->where('id', '!=', $id))
        ->get();
    $users    =  TenantUser::where('master', '!=', '1')->where('status','1')->select('id','name')->get();
    return view('tenant.admin.employees.addEdit', [
        'employee'     => $employee,
        'departments'  => $departments,
        'designations' => $designations,
        'managers'     => $managers,
        'users'        => $users,
    ]);
}


    // ===============================
    // store
    // ===============================
    public function store(Request $request)
    {

        $id = $request->id;

       return $this->saveEmployeeAll($request, $id);
    }




    // ===============================
    // zipcode
    // ===============================

    public function zipcode($zip)
    {
        try {
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->get("https://api.postalpincode.in/pincode/$zip");

            $data = $response->json();

            if (
                isset($data[0]['Status']) &&
                $data[0]['Status'] === 'Success'
            ) {
                return response()->json($data[0]['PostOffice'][0]);
            }

            return response()->json(['error' => 'Invalid Pincode'], 404);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'API connection failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }






    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
       return $this->deleteData(Employee::class,$id,[],[Employee::class => 'report_to']);

    }


    // ===============================
    // STATUS
    // ===============================
    public function status($id)
    {
        return $this->toggleStatus(Employee::class, $id);
    }
}
