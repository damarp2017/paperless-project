<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'name' => $this->name,
            'image' => $this->image,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'sold_at' => $this->created_at->diffForHumans(),
            'datetime' => date_format($this->created_at, "d-m-Y h:i"),
            'category' => [
                'id' => $this->product->category->id,
                'name' => $this->product->category->name,
            ]
        ];
    }
}
