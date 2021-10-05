<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->when(!is_null($this->description), $this->description),
            'price' => $this->when(!is_null($this->price), $this->price),
            'category' => new CategoryResource($this->category),
            'cafe_id' => $this->cafe_id,
        ];
    }
}
