<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Auth\Rules\OfAgeRule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\SignInRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Pipeline\Pipeline;

class SignInController extends Controller
{
    public function __construct(
        private readonly UserRepository $repository
    ){}

    public function __invoke(SignInRequest $request)
    {
        try {
            $payload = $request->validated();

            $payload = app(Pipeline::class)
                ->send($payload)
                ->through([
                    OfAgeRule::class,
                ])
                ->thenReturn();

            $data = $this->repository->store($payload);
        } catch (\Exception $exception) {
            return $this->responseApi([], $exception->getMessage(), 400);
        }
        return $this->responseApi($data);
    }
}
