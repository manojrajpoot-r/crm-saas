<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Import;
use App\Models\ImportFailedRow;
use App\Models\User;
use App\Models\Tenant\TenantUser;

use Illuminate\Support\Facades\DB;
class RetryFailedRowsJob implements ShouldQueue
{


    use Dispatchable, Queueable, SerializesModels,InteractsWithQueue;

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

    public function handle(){
           if($this->type === 'tenant'){
                $this->connectTenant();
            }
        $import = Import::find($this->importId);
        $failed = ImportFailedRow::where('import_id',$import->id)->get();

        foreach($failed as $row){
            try{
                User::create(json_decode($row->row_data,true));
                $row->delete();

                foreach($failed as $row){
                    TenantUser::on('tenant')->create(json_decode($row->row_data,true));
                    $row->delete();
                }


            }catch(\Exception $e){}
        }
    }
}
