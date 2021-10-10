<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'id' => $this->when(!is_null($this?->id), $this->id),
            'path' => $this->path,
            'is_main' => $this->when(!is_null($this->is_main), $this->is_main),
            'is_logo' => $this->when(!is_null($this->is_logo), $this->is_logo),
        ];
    }
}
