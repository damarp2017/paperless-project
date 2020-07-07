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
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'joined_at' => $this->created_at->diffForHumans(),
            'email_verified_at' => ($this->email_verified_at != null) ? $this->email_verified_at->diffForHumans() : "not verified",
//            'stores' => StoreResource::collection($this->stores)
        ];
    }
}
