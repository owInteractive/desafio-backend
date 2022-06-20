<?php

namespace App\Http\Controllers\Api\Movements;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Movement\FilterRequest;
use App\Http\Resources\Api\Movement\MovementResource;
use App\Http\Resources\Api\User\UserResource;
use App\Repositories\Movement\Enums\MovementType;
use App\Repositories\Movement\MovementRepository;
use App\Repositories\User\UserRepository;

class ExportCsvController extends Controller
{
    public function __construct(
        private readonly MovementRepository $repository,
        private readonly UserRepository $repositoryUser
    ){}

    public function __invoke(FilterRequest $request, $id)
    {
        $movements = $this->repository->getByUserId($id);
        $user = $this->repositoryUser->getOne($id);
        $fileName = 'export.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('Type', 'Value', 'Date');
        $columnsHeader = array('name', 'email', 'birthday', 'opening_balance');
        $callback = function() use($movements, $columns, $user, $columnsHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columnsHeader);
            $columnsHeader['name'] = $user->name;
            $columnsHeader['email'] = $user->email;
            $columnsHeader['birthday'] = $user->birthday;
            $columnsHeader['opening_balance'] = number_format($user->opening_balance, 2, '.');
            fputcsv($file, array(
                $columnsHeader['name'],
                $columnsHeader['email'],
                $columnsHeader['birthday'],
                $columnsHeader['opening_balance'],
            ));
            fputcsv($file, $columns);
            foreach ($movements as $movement) {
                $row['Type']  = MovementType::from($movement->type)->name;
                $row['Value'] = number_format($movement->value, 2, '.');
                $row['Date'] = $movement->created_at->format('Y-m-d');
                fputcsv($file, array($row['Type'], $row['Value'], $row['Date']));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
