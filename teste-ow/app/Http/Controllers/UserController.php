<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Transitions;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group User
 *
 * API endpoints for managing users
 */
class UserController extends BaseController
{
    protected $user;
    protected $transitions;

    public function __construct()
    {
        $this->user = new User();
        $this->transitions = new Transitions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAll = $this->user->all()->sortByDesc('created_at');

        return $this->sendResponse($userAll, "user's found");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $createUser = $this->user()->create($request->all());
            return $this->sendResponse($createUser, 'user created');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $request->all(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->sendResponse($user, 'user found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user->updateOrFail($request->all());
            return $this->sendResponse($user, 'user updated');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $request->all(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $checkBalance = $user->balance !== '0.000' ? true : false;
        dd( $user->balance);
        if ($user->checkExistsTransitions() || $checkBalance) {
            return $this->sendError(['user has transitions or user has account balance'], [] ,403);
        }

        $user = $user->deleteOrFail();
        return $this->sendResponse($user, 'user deleted');
    }
}
