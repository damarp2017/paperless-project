<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            // save new order
            $order = new Order();
            $order->store_id = $data['store_id'];
            $order->user_id = $data['user_id'];
            $order->code = date('ymdHis') . "-" . $order->store_id . "-" . $order->user_id;
            $order->save();

            // save product on order_details
            $products = $data['products'];
            for ($i=0; $i < count($products) ; $i++) {
                $detail = new OrderDetail();
                $detail->order_id = $order->id;
                $detail->product_id = $products[$i]['id'];
                $detail->price = $products[$i]['price'];
                $detail->quantity = $products[$i]['quantity'];
                $detail->save();
            }

            return response()->json([
                'status' => true,
                'message' => "order created",
                'data' => [
                    'code' => $order->code,
                    'order' => new OrderResource($data)
                ]
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception,
                'status' => false
            ], 500);
        }

    }
}
