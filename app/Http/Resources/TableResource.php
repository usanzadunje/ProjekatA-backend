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
            'smoking_allowed' => $this->when(!is_null($this->smoking_allowed), $this->smoking_allowed),
            'empty' => $this->empty,
            'position' => [
                'top' => $this->when(!is_null($this->top), $this->top),
                'left' => $this->when(!is_null($this->left), $this->left),
            ],
            'place_id' => $this->place_id,
        ];
    }
}
