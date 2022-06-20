<?php

namespace App\Http\Resources\Api\Movement;

use App\Repositories\Movement\Enums\MovementType;
use Illuminate\Http\Resources\Json\JsonResource;

class MovementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => MovementType::from($this->type)->name,
            'value' => number_format($this->value, 2, '.'),
        ];
    }
}
