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
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->when(!is_null($this->city), $this->city),
            'address' => $this->when(!is_null($this->address), $this->address),
            'email' => $this->when(!is_null($this->email), $this->email),
            'phone' => $this->when(!is_null($this->phone), $this->phone),
            'latitude' => $this->when(!is_null($this->latitude), $this->latitude),
            'longitude' => $this->when(!is_null($this->longitude), $this->longitude),
            'availability_ratio' => $this->takenMaxCapacityTableRatio(),
            'offerings' => OfferingResource::collection($this->whenLoaded('offerings')),
            'subscription_expires_in' => $this->whenPivotLoaded('cafe_user', function() {
                $expires_at = $this->pivot->created_at->addMinutes($this->pivot->expires_in);

                return now()->diffInMinutes($expires_at, false) <= 0 ?
                    0 : now()->diffInMinutes($expires_at, false);
            }),
        ];
    }
}
