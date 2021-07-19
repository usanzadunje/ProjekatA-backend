<?php

namespace App\Http\Resources;

use App\Http\Resources\OfferingResource;
use Illuminate\Http\Request;
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
        if($request->query('getAllColumns') === 'true')
        {
            // Returns all columns
            return [
                'id' => $this->id,
                'name' => $this->name,
                'city' => $this->city,
                'address' => $this->address,
                'email' => $this->email,
                'phone' => $this->phone,
                'taken_capacity' => $this->takenMaxCapacityTableRatio(),
                'offerings' => OfferingResource::collection($this->whenLoaded('offerings')),
                'distance' => $this->when($this->distance !== null, round($this->distance)),
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'taken_capacity' => $this->takenMaxCapacityTableRatio(),
            'distance' => $this->when($this->distance !== null, round($this->distance)),
            //'has_food' => $this->,
            //'has_garden' => $this->,
            //'open_hours' => $this->,
            //'menu' => $this->,
            //'drink_menu' => $this->,
        ];
    }
}
