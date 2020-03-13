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
            'id' => $this->product->id,
            'name' => $this->product->name,
            'description' => $this->product->description,
            'price' => $this->product->price,
            'weight' => $this->product->weight,
            'status' => $this->product->status,
            'available_online' => $this->product->available_online,
            'created_at' => $this->product->created_at->diffForHumans(),
            'category' => [
                'id' => $this->product->category->id,
                'name' => $this->product->category->name,
            ],
            'stock' => [
                'id' => $this->id,
                'quantity' => $this->quantity,
            ],
            'store' => [
                'id' => $this->store->id,
                'name' => $this->store->name,
            ],
            'owner' => [
                'id' => $this->store->owner->id,
                'name' => $this->store->owner->name,
            ]
        ];
    }
}
