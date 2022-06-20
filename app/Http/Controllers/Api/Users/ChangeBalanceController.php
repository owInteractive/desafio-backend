<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ChangeBalanceRequest;
use App\Repositories\User\UserRepository;

class ChangeBalanceController extends Controller
{
    public function __construct(
        private readonly UserRepository $repository
    ){}

    public function __invoke(ChangeBalanceRequest $request, $id)
    {
        try {
            $payload = $request->validated();
            $data = $this->repository->changeBalance($id, $payload);
        } catch (\Exception $exception) {
            return $this->responseApi([], $exception->getMessage(), 204);
        }
        return $this->responseApi($data, '', 200);
    }
}
