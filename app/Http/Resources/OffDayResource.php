<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OffDayResource extends JsonResource
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
            'start_date' => $this->when(
                !is_null($this->start_date),
                "{$this->start_date->day}-{$this->start_date->month}-{$this->start_date->year}"
            ),
            'end_date' => $this->when(
                !is_null($this->start_date) && !is_null($this->number_of_days),
                function() {
                    $endDate = $this->start_date->addDays($this->number_of_days - 1);

                    return "{$endDate->day}-{$endDate->month}-{$endDate->year}";
                }
            ),
            'number_of_days' => $this->when(!is_null($this->number_of_days), $this->number_of_days),
            'status' => $this->when(!is_null($this->status), $this->status),
            'message' => $this->when(!is_null($this->message), $this->message),
        ];
    }
}
