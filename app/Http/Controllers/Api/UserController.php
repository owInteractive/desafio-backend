<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        protected User $repository
    )
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->repository->paginate();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        // $data['password'] = bcrypt($data['password']);
        $user = $this->repository->create($data);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->repository->findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, string $id)
    {
        $data = $request->validated();
        // $data['password'] = bcrypt($data['password']);
        $user = $this->repository->findOrFail($id);
        $user->update($data);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->repository->findOrFail($id)->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
