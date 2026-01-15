<?php

namespace App\Http\Controllers\Tenant\Admin\import;

use App\Http\Controllers\Controller;
use App\Models\Import;
use App\Models\Tenant;
use App\Models\ImportMapping;
use App\Jobs\ProcessUserImportJob;
use App\Jobs\RetryFailedRowsJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Traits\UniversalCrud;
class ImportController extends Controller
{
use UniversalCrud;
    public function import_page()
    {
        $tenants = Tenant::all();
        return view('tenant.admin.import.upload',compact('tenants'));
    }

    public function index(){

        return view('tenant.admin.import.index');
    }

    public function list()
    {
        $query = Import::latest();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('file', function ($t) {

                if (!$t->file) {
                    return "<span class='text-muted'>No File</span>";
                }

                $path = asset($t->file);
                $ext = strtolower(pathinfo($t->file, PATHINFO_EXTENSION));

                if (in_array($ext, ['pdf','doc','docx','xls','xlsx','csv'])) {
                    return "
                        <a href='{$path}' target='_blank' class='btn btn-sm btn-primary'>
                            View
                        </a>
                        <a href='{$path}' download class='btn btn-sm btn-secondary'>
                            Download
                        </a>
                    ";
                }

                return "<span class='text-muted'>Invalid File</span>";
            })
            ->addColumn('progress', function ($t) {
                if ($t->total_rows == 0) return "0%";

                $percent = round(($t->processed_rows / $t->total_rows) * 100);

                return "
                    <div class='progress'>
                        <div class='progress-bar bg-success'
                            role='progressbar'
                            style='width: {$percent}%'>
                            {$percent}%
                        </div>
                    </div>
                ";
            })

            ->addColumn('created_at', function($item){
                    return $this->formatDate($item->created_at);
                })
            ->addColumn('status_btn', function ($t) {

                $colors = [
                    'pending' => 'secondary',
                    'processing' => 'warning',
                    'completed' => 'success',
                    'failed' => 'danger'
                ];

                return "<span class='badge bg-{$colors[$t->status]}'>
                            {$t->status}
                        </span>";
            })

            ->addColumn('action', function ($t) {

                if ($t->status != 'failed') {
                    return "<span class='text-muted'>N/A</span>";
                }

                return "<button class='btn btn-danger btn-sm retryImport'
                        data-id='{$t->id}'>
                        Retry
                        </button>";
            })

            ->rawColumns(['file','progress','created_at','status_btn','action'])
            ->make(true);
    }



public function upload(Request $request)
{

    $request->validate([
        'file'=>'required|mimes:csv,xlsx',
        'import_type'=>'required',
        'tenant'=>'required_if:import_type,tenant'
    ]);

    $file = $request->file('file');
    $filename = time().'_'.$file->getClientOriginalName();
    $file->move(public_path('uploads/imports'), $filename);

    $import = Import::create([
        'user_id'=>Auth::id(),
        'file'=>'uploads/imports/'.$filename,
        'status'=>'pending',
        'import_type'=>$request->import_type,
        'tenant_slug'=>$request->tenant
    ]);

    ProcessUserImportJob::dispatch(
        $import->id,
        $request->import_type,
        $request->tenant
    )->onQueue('imports');

    return response()->json(['status'=>true,'message'=>'Import uploaded successfully!','redirect'=>'tenant.import.index']);
}


    public function status($id){
        $import = Import::find($id);
        return response()->json([
            'processed' => $import->processed_rows,
            'total' => $import->total_rows,
            'status' => $import->status
        ]);
    }

    public function retry($id){
        $import = Import::find($id);
        RetryFailedRowsJob::dispatch($import->id);
        return response()->json(['message'=>'Retry started']);
    }

}