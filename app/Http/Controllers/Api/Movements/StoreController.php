<?php

namespace App\Http\Controllers\Api\Movements;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Movement\MovementRequest;
use App\Repositories\Movement\MovementRepository;

class StoreController extends Controller
{
    public function __construct(
        private readonly MovementRepository $repository
    ){}

    public function __invoke(MovementRequest $request)
    {
        try {
            $payload = $request->validated();
            $data = $this->repository->store($payload);
        } catch (\Exception $exception) {
            return $this->responseApi([], $exception->getMessage(), 400);
        }
        return $this->responseApi($data);
    }
}
