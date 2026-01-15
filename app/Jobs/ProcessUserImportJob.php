<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Import;
use App\Models\User;
use  App\Services\ImportService;
use App\Imports\UsersImport;
use App\Models\ImportFailedRow;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class ProcessUserImportJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public $importId;
    public $type;
    public $tenant;

    public function __construct($importId, $type, $tenant=null){
        $this->importId=$importId;
        $this->type=$type;
        $this->tenant=$tenant;
    }

    private function connectTenant()
    {
        $db = 'tenant_' . $this->tenant;

        config(['database.connections.tenant.database' => $db]);

        DB::purge('tenant');
        DB::reconnect('tenant');
    }


    public function handle(ImportService $service)
    {
        if($this->type === 'tenant'){
            $this->connectTenant();
        }

        $import = Import::findOrFail($this->importId);
        $import->update(['status'=>'processing']);

        $path = public_path($import->file);
        $sheet = Excel::toArray(new UsersImport, $path)[0];
        $rows = array_slice($sheet,1);

        foreach(array_chunk($rows,500) as $chunk){
            $service->processChunk($chunk, $import, $this->type);
        }

        $import->update(['status'=>'completed']);
    }


    // public function handle(ImportService $service)
    // {
    //     $import = Import::findOrFail($this->importId);
    //     $import->update(['status'=>'processing']);

    //     $path = public_path($import->file);

    //     $sheet = Excel::toArray(new UsersImport, $path)[0];
    //     $rows = array_slice($sheet,1); // skip header

    //     $import->update(['total_rows'=>count($rows)]);

    //     foreach(array_chunk($rows, 500) as $chunk){
    //         $service->processChunk($chunk, $import);
    //     }

    //     $import->update(['status'=>'completed']);
    // }
}