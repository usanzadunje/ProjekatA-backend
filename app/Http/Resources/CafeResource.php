<?php

namespace App\Http\Resources;

use App\Http\Resources\OfferingResource;
use Illuminate\Http\Request;
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
                'distance' => round($distance),
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'taken_capacity' => $this->takenMaxCapacityTableRatio(),
            'distance' => round($distance),
            //'has_food' => $this->,
            //'has_garden' => $this->,
            //'open_hours' => $this->,
            //'menu' => $this->,
            //'drink_menu' => $this->,
        ];
    }
}
