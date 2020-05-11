<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'store' => [
                'id' => $this->store->id,
                'name' => $this->store->name,
                'store_logo' => $this->store->store_logo,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'image' => $this->user->image,
            ],
            'role' => $this->role,
            'joined_at' => $this->created_at->diffForHumans()
        ];
    }
}
