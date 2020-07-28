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
        if ($this->order->buy_by_user) {
            $buyer = $this->order->buyer_user->name . ' (User)';
        } elseif ($this->order->buy_by_store) {
            $buyer = $this->order->buyer_store->name . ' (Toko)';
        } else {
            $buyer = 'Tidak diketahui';
        }

        return [
            'buyer' => $buyer,
            'discount' => $this->order->discount,
            'order_id' => $this->order_id,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'sold_at' => date_format($this->created_at, 'd-m-Y H:i:s'),
        ];
    }
}
