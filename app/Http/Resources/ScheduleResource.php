<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->when(!is_null($this->id), $this->id),
            'staff' => new UserResource($this->whenLoaded('user')),
            'day' => $this->when(!is_null($this->start_date), $this->start_date?->day),
            'month' => $this->when(!is_null($this->start_date), $this->start_date?->month - 1),
            'year' => $this->when(!is_null($this->start_date), $this->start_date?->year),
            'start_date' => $this->when(
                !is_null($this->start_date),
                "{$this->start_date?->day}-{$this->start_date?->month}-{$this->start_date?->year}"
            ),
            'start_time' => $this->when(
                !is_null($this->start_time),
                substr($this->start_time, 0, 5)
            ),
            'number_of_hours' => $this->when(!is_null($this->number_of_hours), $this->number_of_hours),
        ];
    }
}
