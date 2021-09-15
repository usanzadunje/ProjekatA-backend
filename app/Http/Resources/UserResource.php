<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->when(!is_null($this->id), $this->id),
            'fname' => $this->fname,
            'lname' => $this->lname,
            'bday' => $this->when(!is_null($this->bday), $this->bday),
            'phone' => $this->when(!is_null($this->phone), $this->phone),
            'username' => $this->when(!is_null($this->username), $this->username),
            'avatar' => $this->when(
                !is_null($this->avatar),
                function() {
                    if(!is_null($this->provider_id) || str_starts_with($this->avatar, 'http'))
                    {
                        return $this->avatar;
                    }
                    else
                    {
                        return url('storage/img/user/' . $this->avatar);
                    }
                }
            ),
            'email' => $this->email,
            'cafe' => $this->when($this->cafe, $this->cafe),
            'active' => $this->when(!is_null($this->active), $this->active),
        ];
    }
}
