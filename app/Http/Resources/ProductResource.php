<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'image' => $this->image,
            'description' => $this->description,
            'price' => $this->price,
            'weight' => $this->weight,
            'quantity' => $this->quantity,
            'discount_by_percent' => $this->discount_by_percent,
            'status' => $this->status,
            'available_online' => $this->available_online,
            'created_at' => $this->created_at->diffForHumans(),
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'store' => [
                'id' => $this->store->id,
                'name' => $this->store->name,
                'store_logo' => $this->store->store_logo
            ],
            'owner' => [
                'id' => $this->store->owner->id,
                'name' => $this->store->owner->name,
                'image' => $this->store->owner->image,
            ]
        ];
    }
}
