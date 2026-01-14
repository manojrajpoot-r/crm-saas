<?php

namespace App\Services;

use App\Models\Import;
use App\Models\ImportMapping;
use App\Models\ImportFailedRow;
use App\Models\User;
use Illuminate\Support\Facades\Validator;



class ImportService {

    public function processChunk($rows, $import)
    {
        foreach ($rows as $index => $row) {

            $data = [
                'name'  => $row[0] ?? null,
                'email' => $row[1] ?? null,
                'phone' => $row[2] ?? null,
                'password' => bcrypt('123456'),
            ];

            $validator = Validator::make($data, [
                'name'=>'required',
                'email'=>'required|email|unique:users,email'
            ]);

            if($validator->fails()){
                ImportFailedRow::create([
                    'import_id'=>$import->id,
                    'row_number'=>$index+1,
                    'row_data'=>json_encode($row),
                    'error'=>$validator->errors()->first()
                ]);
                continue;
            }

            User::create($data);
            $import->increment('processed_rows');
        }
    }
}