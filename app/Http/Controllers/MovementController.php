<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Exceptions\MovementNotFoundException;
use App\Models\MovementType;
use App\Repositories\MovementRepository;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    /** @var MovementRepository */
    private $repository;

    public function __construct(MovementRepository $repository)
    {
        $this->repository = $repository;
    }

    public function credit(Request $request)
    {
        $this->validator($request->all(), [
            'value' => 'required|numeric|min:0',
        ]);

        return $this->addMovement(
            $request->user()->id,
            $request->get('value'),
            MovementType::CREDIT
        );
    }

    public function debit(Request $request)
    {
        $this->validator($request->all(), [
            'value' => 'required|numeric|min:0',
        ]);

        return $this->addMovement(
            $request->user()->id,
            $request->get('value') * -1,
            MovementType::DEBIT
        );
    }

    public function reversal(Request $request, $id)
    {
        $movement = $this->repository->getMovementToReversal($request->user()->id, $id);
        if (!$movement) {
            throw new MovementNotFoundException;
        }

        return $this->addMovement(
            $request->user()->id,
            $movement->value * -1,
            MovementType::REVERSAL,
            $movement->id
        );
    }

    public function delete($id)
    {
        $movement = $this->repository->find($id);
        if (!$movement) {
            throw new MovementNotFoundException;
        }

        $this->repository->delete($movement);
        return response()->json([
            "message" => "Movimentação removida com sucesso!"
        ]);
    }

    protected function addMovement(int $userId, float $value, int $type, int $parentId = null)
    {
        $moviment = [
            'user_id' => $userId,
            'movement_type_id' => $type,
            'value' => $value,
            'parent_id' => $parentId
        ];

        return $this->repository->create($moviment);
    }
}
