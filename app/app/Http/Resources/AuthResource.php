<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $user = $this->resource;
        
        return [
            "access_token" => $user->createToken('token-name')->plainTextToken,
        ];
    }
}
