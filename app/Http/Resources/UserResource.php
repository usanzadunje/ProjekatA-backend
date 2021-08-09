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
            'fname' => $this->fname,
            'lname' => $this->lname,
            'bday' => $this->when($this->bday !== null, $this->bday),
            'phone' => $this->when($this->phone !== null, $this->phone),
            'username' => $this->when($this->username !== null, $this->username),
            'avatar' => $this->when(!is_null($this->avatar), function() {
                if(!is_null($this->provider_id) || str_starts_with($this->avatar, 'http'))
                {
                    return $this->avatar;
                }
                else
                {

                    return url('storage/img/user/' . $this->avatar);
                }
            }),
            'email' => $this->email,
            'email_verified' => $this->email_verified_at,
            'cafe_id' => $this->when(Auth::user()->isStaff(), $this->cafe_id),
        ];
    }
}
