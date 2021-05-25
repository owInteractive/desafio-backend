<?php

namespace App\Helpers;


class CSVHelper
{
    public static function generateStreamFile(array $rows, array $columns, array $headers = null)
    {

        return function () use ($rows, $columns, $headers) {
            $file = fopen('php://output', 'w');

            if ($headers) {
                foreach ($headers as $row) {
                    fputcsv($file, $row);
                }
            }

            fputcsv($file, $columns);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
    }

    public static function getResponseHeader($fileName = 'report')
    {
        return [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=${fileName}.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];
    }
}
