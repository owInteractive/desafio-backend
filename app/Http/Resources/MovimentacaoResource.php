<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovimentacaoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    { 
        return [
            'id'=>$this->id,
            'valor'=>$this->valor,
            'operacao'=>$this->operacao,
            'usuario'=>new UserResource(User::find($this->user_id)),
        ];
    }
}
