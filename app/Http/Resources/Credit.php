<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Credit extends JsonResource
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
            'account_id' => $this->account_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->upadted_at
          ];
    }
}
