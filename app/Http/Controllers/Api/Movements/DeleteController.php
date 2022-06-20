<?php

namespace App\Http\Controllers\Api\Movements;

use App\Http\Controllers\Controller;
use App\Repositories\Movement\MovementRepository;

class DeleteController extends Controller
{
    public function __construct(
        private readonly MovementRepository $repository,
    ){}

    public function __invoke($id, $userId)
    {
        try {
            $data = $this->repository->delete($id, $userId);
        } catch (\Exception $exception) {
            return $this->responseApi([], $exception->getMessage(), 400);
        }
        return $this->responseApi($data, 'Delete Movement', 400);
    }
}
