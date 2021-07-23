<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
            'city' => $this->when($this->city !== null, $this->city),
            'address' => $this->when($this->address !== null, $this->address),
            'email' => $this->when($this->email !== null, $this->email),
            'phone' => $this->when($this->phone !== null, $this->phone),
            'latitude' => $this->when($this->latitude !== null, $this->latitude),
            'longitude' => $this->when($this->longitude !== null, $this->longitude),
            'taken_capacity' => $this->takenMaxCapacityTableRatio(),
            'offerings' => OfferingResource::collection($this->whenLoaded('offerings')),
        ];
    }
}
