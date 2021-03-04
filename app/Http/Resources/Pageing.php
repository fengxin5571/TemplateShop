<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pageing extends JsonResource
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
            'total'=>$this->total(),
            'page'=>$this->currentPage(),
            'limit'=>$this->perPage(),
            'pages'=>$this->lastPage(),
            'list'=>$this->items(),
        ];
    }
}
