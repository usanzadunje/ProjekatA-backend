<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CafeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'tables' => TableResource::collection($this->whenLoaded('tables')),
        ];
    }
}
