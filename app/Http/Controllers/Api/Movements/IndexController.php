<?php

namespace App\Http\Controllers\Api\Movements;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Movement\MovementResource;
use App\Http\Resources\Api\User\UserResource;
use App\Repositories\Movement\MovementRepository;
use App\Repositories\User\UserRepository;

class IndexController extends Controller
{
    public function __construct(
        private readonly MovementRepository $repository,
        private readonly UserRepository $repositoryUser
    ){}

    public function __invoke($id)
    {
        try {
            $limit = 2;
            $movements = $this->repository->getByUserIdWithPaginate($id, $limit);
            $data = [
                'user' => new UserResource($this->repositoryUser->getOne($id)),
                'movements' => MovementResource::collection($movements),
                'pagination' => [
                    'per_page' => $movements->perPage(),
                    'current_page' => $movements->currentPage(),
                    'total' => $movements->total(),
                    'last_page' => $movements->lastPage(),
                ]
            ];
        } catch (\Exception $exception) {
            return $this->responseApi([], $exception->getMessage(), 400);
        }
        return $this->responseApi($data, 'List Movements', 400);
    }
}
