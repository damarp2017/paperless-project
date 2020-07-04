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
            'price' =>  (int)$this->price,
            'quantity' => ($this->quantity != null) ? (int)$this->quantity : null,
            'discount_by_percent' => (int)$this->discount_by_percent ? (int)$this->discount_by_percent : null,
            'status' => $this->status,
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
