<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'sell_by_store' => [
                'id' => $this->seller_store->id,
                'name' => $this->seller_store->name,
                'store_logo' => $this->seller_store->store_logo
            ],
            'buy_by_user' => ($this->buy_by_user == null) ? (object) [] : [
                'id' => $this->buyer_user->id,
                'name' => $this->buyer_user->name,
            ],
            'buy_by_store' => ($this->buy_by_store == null) ? (object) [] : [
                'id' => $this->buyer_store->id,
                'name' => $this->buyer_store->name,
            ],
            'order_details' => OrderDetailResource::collection($this->order_detail),
        ];
    }
}
