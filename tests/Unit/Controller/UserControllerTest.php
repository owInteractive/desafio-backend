<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\Exceptions\DeletUserNotPermittedExpection;
use App\Http\Controllers\Exceptions\UserNotFoundException;
use App\Http\Controllers\UserController;
use App\Models\Movement;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    /** @var UserController */
    private $controller;
    /** @var UserRepository */
    private $repository;

    private $users = [
        [
            "id" => 1,
            "name" => "Teste 1",
            "email" => "teste1@teste.com",
            "birthday" => "2000-05-14",
            "balance" => 10,
            "created_at" => "2021-05-14T03:09:26.000000Z",
            "updated_at" => "2021-05-14T03:09:26.000000Z"
        ],
        [
            "id" => 2,
            "name" => "Teste 2",
            "email" => "teste2@teste.com",
            "birthday" => "2000-05-14",
            "balance" => 20,
            "created_at" => "2021-05-14T03:09:26.000000Z",
            "updated_at" => "2021-05-14T03:09:26.000000Z"
        ]
    ];

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->controller = new UserController($this->repository);

        $this->controller = $this->getMockBuilder(UserController::class)
            ->setMethods(['validator'])
            ->setConstructorArgs([$this->repository])
            ->getMock();
    }

    public function testGetAll()
    {
        $this->repository->expects($this->once())
            ->method('findAll')
            ->willReturn($this->users);

        $this->assertEquals(
            $this->controller->getAll(),
            $this->users
        );
    }

    public function testGet()
    {
        $id = 1;

        $this->repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($this->users[0]);

        $this->assertEquals(
            $this->controller->getById($id),
            $this->users[0]
        );
    }

    public function testGetWithExpcetion()
    {
        $id = 1;

        $this->mockUserNotFound($id);

        $this->controller->getById($id);
    }

    public function testCreate()
    {
        $body = [
            "name" => "Nome teste",
            "email" => "teste@teste.com",
            "password" => "teste",
            "birthday" => "14/05/2000"
        ];

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required',
            'birthday' => 'required|date_format:d/m/Y|before:-18 anos',
        ];

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('all')
            ->willReturn($body);

        $request->expects($this->once())
            ->method('toArray')
            ->willReturn($body);

        $this->controller->expects($this->once())
            ->method('validator')
            ->with($body, $rules);

        $this->repository->expects($this->once())
            ->method('create')
            ->with($body)
            ->willReturn($this->users[0]);

        $this->assertEquals(
            $this->controller->create($request),
            $this->users[0]
        );
    }

    public function testDeleteUserNotFound()
    {
        $id = 1;
        $this->mockUserNotFound($id);

        $this->controller->delete($id);
    }

    public function testGetMovement()
    {
        $userRequest = (object) [
            "id" => 1
        ];

        $request = $this->createMock(Request::class);
        $request->page = 1;

        $response = $this->users[0];
        $response['movements'] = [
            "id" => 1,
            "parent_id" => null,
            "value" => "250.00",
            "created_at" => "2021-05-14T00:22:13.000000Z",
            "movement_type" => [
                "id" => 2,
                "title" => "Crédito"
            ]
        ];

        $request->expects($this->once())
            ->method('user')
            ->willReturn($userRequest);

        $this->repository->expects($this->once())
            ->method('getUserWithMovement')
            ->with($userRequest->id, $request->page)
            ->willReturn($response);

        $this->assertEquals(
            $this->controller->getMovement($request),
            $response
        );
    }

    public function testUpdateBalance()
    {
        $body = ["value" => 250];
        $rules = ['value' => 'required|numeric'];
        $userRequest = (object) ["id" => 1];

        $userData = $this->users[0];
        $userData['birthday'] = "14/05/1996";

        $user = new User($userData);
        $user->balance = $body['value'];

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('all')
            ->willReturn($body);

        $this->controller->expects($this->once())
            ->method('validator')
            ->with($body, $rules);

        $request->expects($this->once())
            ->method('user')
            ->willReturn($userRequest);

        $request->expects($this->once())
            ->method('get')
            ->with('value')
            ->willReturn($body["value"]);

        $this->repository->expects($this->once())
            ->method('find')
            ->with($userRequest->id)
            ->willReturn($user);

        $this->repository->expects($this->once())
            ->method('update')
            ->with($user);

        $this->controller->updateBalance($request);
    }

    public function testBalanceTotal()
    {
        $request = $this->createMock(Request::class);
        $userRequest = (object) ["id" => 1];
        $total = 100;

        $request->expects($this->once())
            ->method('user')
            ->willReturn($userRequest);

        $this->repository->expects($this->once())
            ->method('getTotalBalance')
            ->with($userRequest->id)
            ->willReturn($total);

        $this->assertEquals(
            $this->controller->balanceTotal($request),
            ["total" => $total]
        );
    }

    private function mockUserNotFound($id)
    {
        $this->repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(null);

        $this->expectException(UserNotFoundException::class);
    }

}
