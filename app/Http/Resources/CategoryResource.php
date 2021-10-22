<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->when(!is_null($this->id), $this->id),
            'name' => $this->name,
            'products' => $this->when(!is_null($this->products), ProductResource::collection($this->products)),
            'place_id' => $this->when(!is_null($this->place_id), $this->place_id),
        ];
    }
}
