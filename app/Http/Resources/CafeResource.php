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
        $lat = request('latitude') ?? 0;
        $lng = request('longitude') ?? 0;
        $distance = $this->distance ?? DB::select(DB::raw('
            SELECT ST_Distance_Sphere(
                point(?, ?),
                point(?, ?)
            ) distance
        '), [$lng, $lat, $this->longitude, $this->latitude])[0]->distance;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->when($this->city !== null, $this->city),
            'address' => $this->when($this->address !== null, $this->address),
            'email' => $this->when($this->email !== null, $this->email),
            'phone' => $this->when($this->phone !== null, $this->phone),
            'taken_capacity' => $this->takenMaxCapacityTableRatio(),
            'offerings' => OfferingResource::collection($this->whenLoaded('offerings')),
            'distance' => round($distance),
        ];
    }
}
