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
        $sell_by_store = Store::where('id', $this['sell_by_store'])->first();
        $buyer = null;
        $discount = ($request->has('discount')) ? $this['discount'] : 0;
        if ($request->has('buy_by_user')) {
            $buyer = User::where('id', $this['buy_by_user'])->first();
        } elseif ($request->has('buy_by_store')) {
            $buyer = Store::where('id', $this['buy_by_store'])->first();
        }
        $count = count($this['products']);

        $data = (array)null;
        $total_price = (array)null;

        for ($i = 0; $i < $count; $i++) {
            $product = Product::where('id', $this['products'][$i]['id'])->first();
            $product->order_quantity = $this['products'][$i]['quantity'];
            $product->order_price = $this['products'][$i]['price'];
            $total_price_per_item = $this['products'][$i]['price'] * $this['products'][$i]['quantity'];
            $data[] = $product;
            $total_price[] = $total_price_per_item;
        }

        return [
            'sell_by_store' => [
                'id' => $sell_by_store->id,
                'name' => $sell_by_store->name,
            ],
            'buyer' => ($buyer != null) ? ['id' => $buyer->id, 'name' => $buyer->name] : null,
            'order_count' => $count,
            'total_price' => array_sum($total_price),
            'discount' => $discount,
            'total_price_with_discount' => array_sum($total_price)-$discount,
            'products' => ProductOnOrderResource::collection($data)
        ];
    }
}
