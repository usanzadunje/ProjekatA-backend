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
        if($request->query('columns') === 'cafeShowInfo')
        {
            // Returns only columns needed for show screen of one cafe only on frontend
            return [
                'id' => $this->id,
                'name' => $this->name,
                'city' => $this->city,
                'address' => $this->address,
                'email' => $this->email,
                'phone' => $this->phone,
                'free_tables' => $this->freeTablesCount(),
                //'has_food' => $this->,
                //'has_garden' => $this->,
                //'open_hours' => $this->,
                //'menu' => $this->,
                //'drink_menu' => $this->,
            ];
        }
        elseif($request->query('columns') === 'cafeCardInfo')
        {
            // Returns only columns needed to show cafe card info in listing (Home) all cafes screen on frontend
            return [
                'id' => $this->id,
                'name' => $this->name,
                'free_tables' => $this->freeTablesCount(),
                //'has_food' => $this->,
                //'has_garden' => $this->,
                //'open_hours' => $this->,
                //'menu' => $this->,
                //'drink_menu' => $this->,
            ];
        }

        // Returns all columns if no query
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'free_tables' => $this->freeTablesCount(),
            //'has_food' => $this->,
            //'has_garden' => $this->,
            //'open_hours' => $this->,
            //'menu' => $this->,
            //'drink_menu' => $this->,
        ];
    }
}
