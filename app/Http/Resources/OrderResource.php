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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::where('id', $this['user_id'])->first();
        $store = Store::where('id', $this['store_id'])->first();
        $count = count($this['products']);

        $products = new \stdClass();
        $total_price[] = new \stdClass();

        for ($i=0; $i < $count ; $i++) {
            $product = Product::where('id', $this['products'][$i]['id'])->first();
            $product->order_quantity = $this['products'][$i]['quantity'];
            $product->order_price = $this['products'][$i]['price'];
            $total_price_per_item = $this['products'][$i]['price'] * $this['products'][$i]['quantity'];
            array_push($products, $product);
            array_push($total_price, $total_price_per_item);
        }

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'store' => [
                'id' => $store->id,
                'name' => $store->name,
            ],
            'order_count' => $count,
            'total_price' => array_sum($total_price),
            'products' => ProductOnOrderResource::collection($products)
        ];
    }
}
