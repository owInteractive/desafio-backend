<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;

class IndexController extends Controller
{
    public function __construct(
        private readonly UserRepository $repository
    ){}

    public function __invoke()
    {
        $data = $this->repository->getAll();
        return $this->responseApi($data, '', 200);
    }
}
