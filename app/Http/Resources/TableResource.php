<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
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
            'serial_number' => $this->when($this->serial_number !== null, $this->serial_number),
            'smoking_allowed' => $this->when($this->smoking_allowed !== null, $this->smoking_allowed),
            'empty' => $this->empty,
            'cafe_id' => $this->cafe_id,
        ];
    }
}
