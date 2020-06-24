<?php

namespace App\Http\Resources;

use App\Product;
use App\Store;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $buyer = null;
        if ($this->buy_by_user) {
            $buyer = User::where('id', $this->buy_by_user)->first();
        } elseif ($this->buy_by_user) {
            $buyer = Store::where('id', $this->buy_by_store)->first();
        }

        return [
            'id' => $this->id,
            'code' => $this->code,
            'sell_by_store' => [
                'id' => $this->seller_store->id,
                'name' => $this->seller_store->name,
            ],
            'buyer' => ($buyer != null) ? ['id' => $buyer->id, 'name' => $buyer->name] : null,
            'order_count' => count($this->order_detail),
            'discount' => $this->discount,
            'total_discount_by_percent' => $this->total_discount_by_percent,
            'total_price' => $this->total_price,
            'total_price_with_discount' => $this->total_price_with_discount,
            'products' => ProductOnOrderResource::collection($this->order_detail)
        ];
    }
}
