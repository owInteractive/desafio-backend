<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Reversal extends JsonResource
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
            'credit_id' => $this->credit_id,
            'debit_id' => $this->debit_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->upadted_at
          ];
    }
}
