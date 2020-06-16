<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Null_;

class ReportResource extends JsonResource
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
            'buy_by_user' => ($this->order->buy_by_user) ? $this->order->buyer_user->name : null,
            'buy_by_store' => ($this->order->buy_by_store) ? $this->order->buyer_store->name : null,
            'discount' => $this->order->discount,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'sold_at' => date_format($this->created_at, 'd-m-Y H:i:s'),
        ];
    }
}
