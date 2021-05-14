<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\ExportCsvController;
use App\Repositories\MovementRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class ExportCsvControllerTest extends TestCase
{
    /** @var ExportCsvController */
    private $controller;
    /** @var MovementRepository */
    private $repository;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(MovementRepository::class);
        $this->controller = new ExportCsvController($this->repository);

        $this->controller = $this->getMockBuilder(ExportCsvController::class)
            ->setMethods(['exportFile'])
            ->setConstructorArgs([$this->repository])
            ->getMock();
    }

    public function testExportLast30Days()
    {
        $userRequest = (object) ["id" => 1];
        $records = [
            "id" => 1,
            "parent_id" => null,
            "value" => "250.00",
            "created_at" => "2021-05-14T00:22:13.000000Z",
        ];
        $request = $this->createMock(Request::class);

        $request->expects($this->once())
            ->method('user')
            ->willReturn($userRequest);

        $this->repository->expects($this->once())
            ->method('getLast30Days')
            ->with($userRequest->id)
            ->willReturn($records);

        $this->controller->expects($this->once())
            ->method('exportFile')
            ->with('movements_30_days.csv', $records);

        $this->controller->exportLast30Days($request);
    }

    public function exportByDate()
    {
        $userRequest = (object) ["id" => 1];
        $date = "05/2021";
        $records = [
            "id" => 1,
            "parent_id" => null,
            "value" => "250.00",
            "created_at" => "2021-05-14T00:22:13.000000Z",
        ];
        $request = $this->createMock(Request::class);

        $request->expects($this->once())
            ->method('user')
            ->willReturn($userRequest);

        $this->repository->expects($this->once())
            ->method('getByDate')
            ->with($userRequest->id, $date)
            ->willReturn($records);

        $this->controller->expects($this->once())
            ->method('exportFile')
            ->with("movements_$date.csv", $records);

        $this->controller->exportLast30Days($request, $date);
    }

    public function exportAll()
    {
        $userRequest = (object) ["id" => 1];
        $records = [
            "id" => 1,
            "parent_id" => null,
            "value" => "250.00",
            "created_at" => "2021-05-14T00:22:13.000000Z",
        ];
        $request = $this->createMock(Request::class);

        $request->expects($this->once())
            ->method('user')
            ->willReturn($userRequest);

        $this->repository->expects($this->once())
            ->method('getByUser')
            ->with($userRequest->id)
            ->willReturn($records);

        $this->controller->expects($this->once())
            ->method('exportFile')
            ->with('movements.csv', $records);

        $this->controller->exportLast30Days($request);
    }

}
