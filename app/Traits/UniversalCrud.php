<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\Tenant;
use App\Models\Domain;
use App\Models\Tenant\Employee;
use App\Models\Tenant\EmployeeAddress;
use App\Models\Tenant\Report;
use App\Models\Tenant\EmployeePersonalInfo;
use App\Models\Tenant\EmployeeEmergencyContact;
use App\Models\Tenant\EmployeeFamilyInfo;
use App\Models\Tenant\EmployeeBankInfo;
use App\Models\Tenant\EmployeeUpiInfo;
use App\Models\Tenant\EmployeeEducation;
use App\Models\Tenant\EmployeeExperience;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



trait UniversalCrud
{
   public function formatDate($date){
        return $date ? $date->format('d F Y') : '';
    }
    public function autoUpload(Request $request, $model, $id = null)
    {
        $modelName = strtolower(Str::plural(class_basename($model)));
        $uploaded = [];

        foreach ($request->files->keys() as $field) {

            //  skip multiple documents
            if ($field === 'documents') {
                continue;
            }

            $folder = "uploads/{$modelName}/{$field}";
            $path   = public_path($folder);

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $oldFile = $id ? optional($model::find($id))->{$field} : null;

            if ($oldFile && file_exists($path.'/'.$oldFile)) {
                unlink($path.'/'.$oldFile);
            }

            $file = $request->file($field);

            if (!$file) continue;

            $name = time().'_'.$file->getClientOriginalName();
            $file->move($path, $name);

            $uploaded[$field] = $name;
        }

        return $uploaded;
    }


    public function uploadMultipleDocs($request, $record, $relation, $module)
    {
        if (!$request->hasFile('documents')) {
            return;
        }

        $folder = 'uploads/' . Str::plural(strtolower($module)) . '/documents';
        $destination = public_path($folder);

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        foreach ($request->file('documents') as $index => $file) {

            $filename = time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $file->move($destination, $filename);

            $record->$relation()->create([
                'file' => $filename, //  only name in DB
            ]);
        }
    }



public function saveData(Request $request, $model, $id = null)
{

    $rules = method_exists($model, 'rules') ? $model::rules($id) : [];
    Validator::make($request->all(), $rules)->validate();

    $data = $request->except([
        '_token',
        'documents',
        'document_titles'
    ]);

        if (!empty($data['actual_start_date']) && !empty($data['end_date'])) {
            $start = Carbon::parse($data['actual_start_date']);
            $end   = Carbon::parse($data['end_date']);

            $data['total_days'] = $start->diffInDays($end) + 1;
        }

        if (Auth::check()) {
            $data['created_by'] = Auth::id();
            $data['uploaded_by'] = Auth::id();
        }

        if (!empty($request->assigned_to)) {
            $data['assigned_by'] = Auth::id();
            $data['assigned_at'] = now();
            $data['is_assigned'] = 1;
        }

    // ===== MULTI-ROW INSERT =====
    if (!$id && isset($data['group']) && is_array($data['group'])) {
        foreach ($data['group'] as $action) {
            $rows[] = ['name'=>$data['name'],'group'=>$action];
        }
        $model::insert($rows);

        return response()->json(['status'=>'success']);
    }

    // ===== SINGLE FILE UPLOAD =====
    if ($request->files->count() > 0) {
        $files = $this->autoUpload($request, $model, $id);
        $data  = array_merge($data, $files);
    }

    // ===== CREATE / UPDATE =====
    $record = $id
        ? tap($model::findOrFail($id))->update($data)
        : $model::create($data);


    // ===== MULTIPLE users =====
       if ($request->filled('user_id')) {
            $record->teamMembers()->sync($request->user_id);
        }

        if ($request->filled('client_id')) {
            $record->clients()->sync($request->client_id);
        }


    // ===== MULTIPLE DOCUMENTS =====
    if ($request->hasFile('documents')) {
        $this->uploadMultipleDocs(
            $request,
            $record,
            'documents',
            class_basename($model)
        );
    }

    return response()->json([
        'status' => 'success',
        'message' => $id ? 'Updated successfully' : 'Created successfully'
    ]);
}



    // TENANT SPECIAL STORE


// public function saveTenant(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'name'   => 'required',
//         'domain' => 'required|unique:domains,domain'
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'status' => 'error',
//             'errors' => $validator->errors()
//         ], 422);
//     }

//     $tenantId = (string) Str::uuid();
//     $dbName   = 'tenant_' . strtolower(str_replace(' ', '_', $request->name));
//     $slug     = Str::slug($request->name);

//     $exists = DB::select(
//         "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?",
//         [$dbName]
//     );

//     if ($exists) {
//         return response()->json([
//             'status' => 'error',
//             'message' => "Database `$dbName` already exists!"
//         ], 409);
//     }

//     DB::statement("CREATE DATABASE `$dbName`");

//     // Save tenant
//     $tenant = Tenant::create([
//         'id'       => $tenantId,
//         'name'     => $request->name,
//         'slug'     => $slug,
//         'database' => $dbName,
//     ]);

//     // Save domain
//     Domain::create([
//         'domain'    => $request->domain,
//         'tenant_id' => $tenantId,
//     ]);

//     // Run migration
//     config(['database.connections.tenant.database' => $dbName]);

//     Artisan::call('migrate', [
//         '--database' => 'tenant',
//         '--path'     => 'database/migrations/tenant',
//         '--force'    => true
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'Tenant created successfully!',
//         'database' => $dbName
//     ]);
// }

public function saveTenant(Request $request)
{
    $isUpdate = $request->has('id'); // agar id hai toh update mode

    $rules = [
        'name'   => 'required',
        'domain' => $isUpdate
            ? 'required|unique:domains,domain,' . $request->id . ',tenant_id' // update me unique exclude current tenant
            : 'required|unique:domains,domain'
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    if ($isUpdate) {
        // ================= UPDATE =================
        $tenant = Tenant::findOrFail($request->id);
        $tenant->name = $request->name;
        $tenant->slug = Str::slug($request->name);
        $tenant->save();

        $domain = $tenant->domains()->first();
        if ($domain) {
            $domain->domain = $request->domain;
            $domain->save();
        } else {
            // agar domain record missing ho toh create kar do
            Domain::create([
                'tenant_id' => $tenant->id,
                'domain'    => $request->domain
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tenant updated successfully!',
        ]);

    } else {
        // ================= CREATE =================
        $tenantId = (string) Str::uuid();
        $dbName   = 'tenant_' . strtolower(str_replace(' ', '_', $request->name));

        $exists = DB::select(
            "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?",
            [$dbName]
        );

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => "Database `$dbName` already exists!"
            ], 409);
        }

        DB::statement("CREATE DATABASE `$dbName`");

        $tenant = Tenant::create([
            'id'       => $tenantId,
            'name'     => $request->name,
            'slug'     => Str::slug($request->name),
            'database' => $dbName,
        ]);

        Domain::create([
            'tenant_id' => $tenantId,
            'domain'    => $request->domain,
        ]);

        // Run migration
        config(['database.connections.tenant.database' => $dbName]);

        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path'     => 'database/migrations/tenant',
            '--force'    => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tenant created successfully!',
            'database' => $dbName
        ]);
    }
}




        // SAVE EMPLOYEE ALL


public function saveEmployeeAll($request, $employeeId = null)
{
    $validator = Validator::make($request->all(), [
        'first_name'      => 'required',
        'last_name'       => 'required',
        'phone'           => 'required',
        'emergency_phone' => 'required',
        'dob'             => 'required',
        'gender'          => 'required',
        'personal_email'  => 'required|email',
        'corporate_email' => 'required|email',
        'join_date'       => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        DB::transaction(function () use ($request, $employeeId) {

            $user = Auth::user();

            $employee = Employee::updateOrCreate(
                ['id' => $employeeId],
                array_merge(
                    $request->only([
                        'employee_id',
                        'first_name',
                        'last_name',
                        'phone',
                        'emergency_phone',
                        'dob',
                        'gender',
                        'personal_email',
                        'corporate_email',
                        'department_id',
                        'designation_id',
                        'report_to',
                        'join_date',
                    ]),
                    ['user_id' => $user->id]
                )
            );

            if (!$employee) {
                throw new \Exception('Employee save failed');
            }

            EmployeeAddress::updateOrCreate(
                ['employee_id' => $employee->id],
                $request->only([
                    'present_address',
                    'present_landmark',
                    'present_zipcode',
                    'present_country',
                    'present_state',
                    'present_city',
                    'permanent_address',
                    'permanent_landmark',
                    'permanent_zipcode',
                    'permanent_country',
                    'permanent_state',
                    'permanent_city'
                ])
            );

            EmployeePersonalInfo::updateOrCreate(
                ['employee_id' => $employee->id],
                $request->only([
                    'passport_no',
                    'passport_expiry',
                    'identity_no',
                    'nationality',
                    'religion',
                    'marital_status',
                    'spouse_name',
                    'children'
                ])
            );

            EmployeeEmergencyContact::updateOrCreate(
                ['employee_id' => $employee->id],
                $request->only(['name','relation','phone','address'])
            );

            EmployeeFamilyInfo::updateOrCreate(
                ['employee_id' => $employee->id],
                $request->only(['name','relation','phone'])
            );

            EmployeeBankInfo::updateOrCreate(
                ['employee_id' => $employee->id],
                $request->only([
                    'account_name',
                    'bank_name',
                    'account_no',
                    'ifsc',
                    'pan_no',
                    'uan_no'
                ])
            );

            EmployeeUpiInfo::updateOrCreate(
                ['employee_id' => $employee->id],
                $request->only(['upi_id','upi_app','is_primary'])
            );

            EmployeeEducation::updateOrCreate(
                ['employee_id' => $employee->id],
                $request->only([
                    'institute',
                    'degree',
                    'stream',
                    'from_date',
                    'to_date',

                ])
            );

            EmployeeExperience::updateOrCreate(
                ['employee_id' => $employee->id],
                $request->only([
                    'company_name',
                    'designation',
                    'from_date',
                    'to_date',
                ])
            );
        });

    } catch (\Throwable $e) {

        Log::error('Employee save failed', [
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'status' => 'error',
            'message' =>  $e->getMessage()
        ], 500);
    }

    return response()->json([
        'status' => 'success',
        'message' => $employeeId ? 'Employee updated successfully!' : 'Employee created successfully!',
        'redirect' => route('tenant.employees.index')
    ]);
}






    // DELETE
public function deleteData($model, $id, $relations = [], $nullRelations = [])
{
    $data = $model::find($id);

    if (!$data) {
        return response()->json([
            'success' => false,
            'message' => 'Record not found!'
        ], 404);
    }

    // Set null relations (like report_to)
    foreach ($nullRelations as $nullModel => $column) {
        $nullModel::where($column, $id)->update([
            $column => null
        ]);
    }

    // Delete related records
    foreach ($relations as $relModel => $column) {
        $relModel::where($column, $id)->delete();
    }

    $data->delete();

    return response()->json([
        'success' => true,
        'message' => 'Deleted Successfully'
    ]);
}


    // STATUS TOGGLE
    public function toggleStatus($model, $id)
    {
        $record = $model::findOrFail($id);
        $record->status = !$record->status;
        $record->save();

        return [
            'success' =>true,
            'status'  => $record->status,
            'message' => 'Status updated successfully!'
        ];
    }



        public function toggleStatusMultiple($request, $modelClass, $id)
        {
            $validator = Validator::make($request->all(), [
                'status' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $record = $modelClass::findOrFail($id);

            $record->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success'  => true,
                'message' => 'Status updated successfully'
            ]);
        }



    public function tenant_toggleStatus($id)
    {
        $tenant = Tenant::findOrFail($id);

        $newStatus = $tenant->status ? 0 : 1;

        // Tenant status
        $tenant->update([
            'status' => $newStatus
        ]);

        // Domain status bhi same
        Domain::where('tenant_id', $tenant->id)->update([
            'is_active' => $newStatus
        ]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => $newStatus ? 'Active' : 'Inactive'
        ]);
    }



     public function changePasswordTrait(Request $request, $model, $id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = $model::findOrFail($id);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully'
        ]);
    }




}
