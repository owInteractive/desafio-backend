<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\MovementController;
use App\Models\MovementType;
use App\Repositories\MovementRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class MovementControllerTest extends TestCase
{
    /** @var MovementController */
    private $controller;
    /** @var MovementRepository */
    private $repository;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(MovementRepository::class);
        $this->controller = new MovementController($this->repository);

        $this->controller = $this->getMockBuilder(MovementController::class)
            ->setMethods(['addMovement', 'validator'])
            ->setConstructorArgs([$this->repository])
            ->getMock();
    }

    public function testCredit()
    {
        $value = 100;
        $userRequest = (object) ["id" => 1];
        $response = [
            "value" => 200,
            "parent_id" => null,
            "created_at" => "2021-05-14T15:11:07.000000Z",
            "id" => 4
        ];

        $body = [
            "value" => $value
        ];

        $rules = [
            'value' => 'required|numeric|min:0',
        ];

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('get')
            ->with('value')
            ->willReturn($value);

        $request->expects($this->once())
            ->method('all')
            ->willReturn($body);

        $request->expects($this->once())
            ->method('user')
            ->willReturn($userRequest);

        $this->controller->expects($this->once())
            ->method('validator')
            ->with($body, $rules);

        $this->controller->expects($this->once())
            ->method('addMovement')
            ->with($userRequest->id, $value, MovementType::CREDIT)
            ->willReturn($response);

        $this->assertEquals(
            $this->controller->credit($request),
            $response
        );
    }

    public function testDebit()
    {
        $value = 100;
        $userRequest = (object) ["id" => 1];
        $response = [
            "value" => 200,
            "parent_id" => null,
            "created_at" => "2021-05-14T15:11:07.000000Z",
            "id" => 4
        ];

        $body = [
            "value" => $value
        ];

        $rules = [
            'value' => 'required|numeric|min:0',
        ];

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('get')
            ->with('value')
            ->willReturn($value);

        $request->expects($this->once())
            ->method('all')
            ->willReturn($body);

        $request->expects($this->once())
            ->method('user')
            ->willReturn($userRequest);

        $this->controller->expects($this->once())
            ->method('validator')
            ->with($body, $rules);

        $this->controller->expects($this->once())
            ->method('addMovement')
            ->with($userRequest->id, $value * -1, MovementType::DEBIT)
            ->willReturn($response);

        $this->assertEquals(
            $this->controller->debit($request),
            $response
        );
    }

    public function testReversal()
    {
        $id = 1;
        $moviment = [
            "value" => 200,
            "parent_id" => null,
            "created_at" => "2021-05-14T15:11:07.000000Z",
            "id" => $id
        ];
        $response = [
            "value" => -200,
            "parent_id" => $id,
            "created_at" => "2021-05-14T15:11:07.000000Z",
            "id" => 4
        ];
        $userRequest = (object) ["id" => 1];

        $request = $this->createMock(Request::class);

        $request->expects($this->exactly(2))
            ->method('user')
            ->willReturn($userRequest);

        $this->repository->expects($this->once())
            ->method('getMovementToReversal')
            ->with($userRequest->id, $id)
            ->willReturn((object) $moviment);

        $this->controller->expects($this->once())
            ->method('addMovement')
            ->with($userRequest->id, $moviment['value'] * -1, MovementType::REVERSAL)
            ->willReturn($response);

        $this->assertEquals(
            $this->controller->reversal($request, $id),
            $response
        );
    }
}
