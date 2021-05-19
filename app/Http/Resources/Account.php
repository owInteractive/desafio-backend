<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Account extends JsonResource
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
            'saldo' => $this->saldo,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->upadted_at
          ];
    }
}
