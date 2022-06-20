<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ChangeBalanceRequest;
use App\Repositories\User\UserRepository;

class BalanceController extends Controller
{
    public function __construct(
        private readonly UserRepository $repository
    ){}

    public function __invoke($id)
    {
        try {
            $data = $this->repository->balance($id);
        } catch (\Exception $exception) {
            return $this->responseApi([], $exception->getMessage(), 204);
        }
        return $this->responseApi($data, '', 200);
    }
}
