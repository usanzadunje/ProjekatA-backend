<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
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
            'full_name' => $this->fname . ' ' . $this->lname,
            'bday' => $this->when($this->bday !== null, $this->bday),
            'phone' => $this->when($this->phone !== null, $this->phone),
            'username' => $this->when($this->username !== null, $this->username),
            'avatar' => $this->when($this->avatar !== null, $this->avatar),
            'email' => $this->email,
            'email_verified' => $this->email_verified_at,
            'cafe_id' => $this->when(Auth::user()->isStaff(), $this->cafe_id),
        ];
    }
}
