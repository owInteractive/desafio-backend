<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Movimentacao extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'valor' => $this->valor,
            'user_id' => $this->user_id,
            'nome_movimentacao' => $this->nome_movimentacao,
            'created_at' => $this->created_at,
            'updated_at' => $this->upadted_at
          ];
    }
}
