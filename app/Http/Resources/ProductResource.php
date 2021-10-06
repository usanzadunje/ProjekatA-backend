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
            'image_path' => $this->when(!is_null($this->image_path), $this->image_path),
            'cafe_id' => $this->cafe_id,
        ];
    }
}
