<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GenericCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->collection->count()){
            return [
                'total_in_page' =>$this->collection->count(),
                'success'=> true,
                'status'=> 200,
                'data' => $this->collection
            ];
        } else{

            throw new HttpException(204);

        }
    }
}
