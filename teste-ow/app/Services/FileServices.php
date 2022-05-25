<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class FileServices
{

    public function createCSVFile(Array|Collection $data, Array $headers , String $name)
    {
        $path = storage_path('app/public/tmp');

        if(!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }        

        $fullpath = $path . '/'. $name;

        // open csv file for writing
        $f = fopen($fullpath, 'w');

        if ($f === false) {
            die('Error opening the file ' . $fullpath);
        }

        fputcsv($f, $headers);

        // write each row at a time to a file
        foreach ($data as $row) {
            fputcsv($f, $row);
        }

        // close the file
        fclose($f);
    }
}
