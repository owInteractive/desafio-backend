<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\Users\Rules\HasBalanceRule;
use App\Http\Controllers\Api\Users\Rules\HasMovementRule;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use Illuminate\Pipeline\Pipeline;

class DeleteController extends Controller
{
    public function __construct(
        private readonly UserRepository $repository
    ){}

    public function __invoke($id)
    {
        try {
            $user = $this->repository->getOne($id);
            app(Pipeline::class)
                ->send($user)
                ->through([
                    HasBalanceRule::class,
                    HasMovementRule::class,
                ])
                ->thenReturn();
            $data = $this->repository->delete($id);
        } catch (\Exception $exception) {
            return $this->responseApi([], $exception->getMessage(), 400);
        }
        return $this->responseApi($data, 'User deleted successfully!', 200);
    }
}
