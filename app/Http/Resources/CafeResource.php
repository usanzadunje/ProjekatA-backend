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
        // Returns only columns needed to show
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->when($request->route()->getName() !== 'cafes/chunked', $this->city),
            'address' => $this->when($request->route()->getName() !== 'cafes/chunked', $this->address),
            'email' => $this->when($request->route()->getName() !== 'cafes/chunked', $this->email),
            'phone' => $this->when($request->route()->getName() !== 'cafes/chunked', $this->phone),
            'free_tables' => $this->freeTablesCount(),
            //'has_food' => $this->,
            //'has_garden' => $this->,
            //'open_hours' => $this->,
            //'menu' => $this->,
            //'drink_menu' => $this->,
        ];

    }
}
