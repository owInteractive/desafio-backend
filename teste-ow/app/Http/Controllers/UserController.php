<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Transitions;
use App\Models\User;
use Illuminate\Http\Request;

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
        $createUser = $this->user()->create($request->all());

        return $this->sendResponse($createUser, 'user created');
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
        $user->updateOrFail($request->all());

        return $this->sendResponse($user, 'user updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $balance = $user->saldo === '0.000' ? true : false;

        if ($user->checkExistsTransitions() || $balance) {
            $user = $user->deleteOrFail();
            return $this->sendResponse($user, 'user deleted');
        }

        return $this->sendResponse([], 'user has transitions or user has account balance');
    }
}
