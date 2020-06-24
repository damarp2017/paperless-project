<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderProductResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Store;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function history(Request $request)
    {
        $data = $request->all();
        $all_orders = Order::where('buy_by_user', auth()->user()->id)->get();
        $user = auth()->user();

        if ($request->has('store_id')) {
            $store = Store::where('id', $data['store_id'])->first();
            $out = Order::where('buy_by_store', $store->id)->get();
            $in = Order::where('sell_by_store', $store->id)->get();
        }
        return response()->json([
            'status' => true,
            'message' => 'OK',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'image' => $user->image,
                    'orders' => OrderProductResource::collection($all_orders),
                ],
                'store' => (!$request->has('store_id')) ? (object)[] : [
                    'id' => $store->id,
                    'name' => $store->name,
                    'store_logo' => $store->store_logo,
                    'out' => OrderProductResource::collection($out),
                    'in' => OrderProductResource::collection($in),
                ]
            ]
        ]);

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $total_price = (array)null;
        $total_discount_by_percent = (array)null;
        $total_price_with_discount = (array)null;

        // save new order
        $order = new Order();
        $order->sell_by_store = $data['sell_by_store'];
        if ($request->has('buy_by_user')) {
            $order->buy_by_user = $data['buy_by_user'];
            $order->code = date('ymdHis') . "-" . $order->sell_by_store . "-" . $order->buy_by_user . "-0";
        } elseif ($request->has('buy_by_store')) {
            $order->buy_by_store = $data['buy_by_store'];
            $order->code = date('ymdHis') . "-" . $order->sell_by_store . "-0-" . $order->buy_by_store;
        } else {
            $order->code = date('ymdHis') . "-" . $order->sell_by_store . "-0-0";
        }
        $order->sell_by_user = auth()->user()->id;
        $order->discount = ($request->has('discount')) ? $data['discount'] : 0;
        $order->save();


        // save product on order_details
        $products = $data['products'];
        for ($i = 0; $i < count($products); $i++) {
            $detail = new OrderDetail();
            $product = Product::where('id', $products[$i]['id'])->first();
            $detail->order_id = $order->id;
            $detail->product_id = $products[$i]['id'];
            $detail->name = $product->name;
            $detail->image = $product->image;
            $detail->price = $products[$i]['price'];
            $detail->quantity = $products[$i]['quantity'];
            $detail->discount_by_percent = $product->discount_by_percent ? $product->discount_by_percent : 0;
            $total_price[] = $detail->price * $detail->quantity;
            $total_discount_by_percent[] = $detail->price * $detail->discount_by_percent/100 * $detail->quantity;
            $detail->save();
            if ($product->quantity != null) {
                $product->quantity -= $detail->quantity;
                $product->update();
            }
        }
        $order->total_price = array_sum($total_price);
        $order->total_discount_by_percent = array_sum($total_discount_by_percent);
        $order->total_price_with_discount = $order->total_price - $order->total_discount_by_percent - $order->discount;
        $order->update();

        return response()->json([
            'status' => true,
            'message' => "order created",
            'data' => new OrderResource($order),
        ], 201);
    }
}
