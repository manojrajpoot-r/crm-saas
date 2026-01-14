<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class UsersImport implements ToArray
{
    public function array(array $array)
    {
        // Ye method automatically Excel ke rows ko array me dega
        return $array;
    }
}
