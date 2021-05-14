<?php

namespace App\Http\Controllers;

use App\Repositories\MovementRepository;
use Illuminate\Http\Request;

class ExportCsvController extends Controller
{
    /** @var MovementRepository */
    private $repository;

    public function __construct(MovementRepository $repository)
    {
        $this->repository = $repository;
    }

    public function exportLast30Days(Request $request)
    {
        $records = $this->repository->getLast30Days(
            $request->user()->id
        );

        return $this->exportFile('movements_30_days.csv', $records);
    }

    public function exportByDate(Request $request, $date)
    {
        $this->validator(["date" => $date], [
            'date' => 'required|date_format:m_Y'
        ]);

        $records = $this->repository->getByDate(
            $request->user()->id, $date
        );

        return $this->exportFile("movements_$date.csv", $records);
    }

    public function exportAll(Request $request)
    {
        $records = $this->repository->getByUser(
            $request->user()->id
        );

        return $this->exportFile("movements.csv", $records);
    }

    protected function exportFile($fileName, $records)
    {
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = ['ID', 'Value', 'Type', 'Date', 'Reversal ID', 'User ID', 'User name', 'User e-mail', 'User birthday', 'User balance'];
        $callback = function () use ($records, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($records as $record) {
                $row['ID']  = $record->id;
                $row['Value'] = $record->value;
                $row['Type'] = $record->movementType->title;
                $row['Date'] = $record->created_at;
                $row['Reversal ID'] = $record->parent_id ?? '';
                $row['User ID'] = $record->user->id;
                $row['User name'] = $record->user->name;
                $row['User e-mail'] = $record->user->email;
                $row['User birthday'] = $record->user->birthday;
                $row['User balance'] = $record->user->balance;

                fputcsv($file, [
                    $row['ID'],
                    $row['Value'],
                    $row['Type'],
                    $row['Date'],
                    $row['Reversal ID'],
                    $row['User ID'],
                    $row['User name'],
                    $row['User birthday'],
                    $row['User balance'],
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }
}
