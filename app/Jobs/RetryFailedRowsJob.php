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

class RetryFailedRowsJob implements ShouldQueue
{


    use Dispatchable, Queueable, SerializesModels,InteractsWithQueue;

    public $importId;
    public function __construct($importId){ $this->importId=$importId; }

    public function handle(){
        $import = Import::find($this->importId);
        $failed = ImportFailedRow::where('import_id',$import->id)->get();

        foreach($failed as $row){
            try{
                User::create(json_decode($row->row_data,true));
                $row->delete();
            }catch(\Exception $e){}
        }
    }
}