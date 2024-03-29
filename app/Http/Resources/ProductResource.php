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
            'id' => $this->when(!is_null($this->id), $this->id),
            'name' => $this->name,
            'description' => $this->when(!is_null($this->description), $this->description),
            'price' => $this->when(!is_null($this->price), $this->price),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'category_id' => $this->when(!is_null($this->category_id), $this->category_id),
            'place_id' => $this->place_id,
        ];
    }
}
