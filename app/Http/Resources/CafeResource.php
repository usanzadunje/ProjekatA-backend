<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CafeResource extends JsonResource
{
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
            'categories' => $this->when(
                $request->routeIs('cafes/show') && $request->query('products'),
                CategoryResource::collection($this->allProductCategories())
            ),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'subscription_expires_in' => $this->whenPivotLoaded('cafe_user', function() {
                if($this->pivot->expires_in)
                {
                    $expires_at = $this->pivot->created_at->addMinutes($this->pivot->expires_in);

                    return now()->diffInMinutes($expires_at, false) + 1;
                }
                else
                {
                    return null;
                }
            }),
            'working_hours' => $this->when(
                !is_null($this->mon_fri) && !is_null($this->saturday) && !is_null($this->sunday),
                [
                    'mon_fri' => $this->mon_fri,
                    'saturday' => $this->saturday,
                    'sunday' => $this->sunday,
                ]),
        ];
    }
}
