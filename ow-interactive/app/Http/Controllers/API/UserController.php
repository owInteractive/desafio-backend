<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Response;


class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * @OA\Post(
     *      path="/users/register",
     *      operationId="users.store",
     *      tags={"User"},
     *      summary="Store a newly created User in storage",
     *      description="Store User",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateUserRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      )
     * )
     */
    public function store(CreateUserRequest $request)
    {
        try {
            $input = $request->all();
            $user = $this->userRepository->create($input);
            return $this->sendResponse($user->toArray(), 'User saved successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="users.index",
     *      tags={"User"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Get a listing of the Users.",
     *      description="Get all Users",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      )
     * )
     */
    public function index()
    {
        try {
            $users = $this->userRepository->paginate(10);
            return $this->sendResponse($users, 'Users retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      operationId="users.show",
     *      tags={"User"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Display the specified User",
     *      description="Get User",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      )
     * )
     */
    public function show($id)
    {
        try {
            /** @var User $user */
            $user = $this->userRepository->find($id);

            if (empty($user)) {
                return $this->sendError('User not found');
            }

            return $this->sendResponse($user->toArray(), 'User retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/users/destroy/{id}",
     *      operationId="users.destroy",
     *      tags={"User"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Remove the specified User from storage",
     *      description="Delete User",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      )
     *      )
     * )
     */
    public function destroy($id)
    {
        try {
            $user = $this->userRepository->find($id);
            if (empty($user)) {
                return $this->sendError('User not found');
            }

            $user->delete();
            return $this->sendSuccess('User deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
}
