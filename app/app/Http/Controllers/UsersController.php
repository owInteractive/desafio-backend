<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpeningBalanceRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use Exception;
use App\Services\Users\UserServiceContract;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    public function __construct(
        protected UserServiceContract $userService
    ) {  
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $user = $this->userService->storeUser($request->all());
            
            return response(new UserResource($user), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } 
    }

    public function list()
    {
        try {
            $users = $this->userService->listUsers();
            
            return response(new UserResource($users), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } 
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getUser($id);
            
            return response(new UserResource($user), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->destroyUser($id);
            
            return response()->json('Usuário Excluido', Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function saveOpeningBalance($id, OpeningBalanceRequest $request)
    {
        try {
            $user = $this->userService->saveOpeningBalance($id, $request->all());

            return response(new UserResource($user), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
