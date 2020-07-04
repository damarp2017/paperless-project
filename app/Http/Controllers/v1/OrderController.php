<?php

namespace App\Http\Controllers\v1;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderProductResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Notification;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Store;
use App\User;
use Illuminate\Http\Request;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

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
            $total_discount_by_percent[] = $detail->price * $detail->discount_by_percent / 100 * $detail->quantity;
            $detail->save();
            if ($product->quantity != null) {
                if ($product->quantity >= $detail->quantity) {
                    $product->quantity -= $detail->quantity;
                    $product->update();
                } else {
                    $order_details = OrderDetail::where('order_id', $order->id)->get();
                    foreach ($order_details as $order_detail) {
                        $order_detail->forceDelete();
                    }
                    $order->forceDelete();
                    return response()->json([
                        'status' => false,
                        'message' => "Maximum order $detail->name is $product->quantity",
                        'data' => (object)[],
                    ], 400);
                }
            }
        }
        $order->total_price = array_sum($total_price);
        $order->total_discount_by_percent = array_sum($total_discount_by_percent);
        $order->total_price_with_discount = $order->total_price - $order->total_discount_by_percent - $order->discount;
        $order->update();

        $store = Store::where('id', $order->sell_by_store)->first();

        if ($request->has('buy_by_user')) {
            // jika pembeli adalah user
            $user = User::where('id', $data['buy_by_user'])->first();
            $token_user = $user->fcm_token;

            $notif = new Notification();
            $notif->sender = $store->id;
            $notif->receiver = $user->id;
            $notif->type = Notification::$ORDER;
            $notif->title = "Transaksi Pembelian Berhasil!";
            $notif->subtitle = "Selamat "
                . strtoupper($user->name) . ", transaksi pembelian anda sejumlah Rp. "
                . number_format($order->total_price_with_discount, 2) . " pada "
                . strtoupper($store->name) . " telah berhasil dilakukan.";
            $notif->save();

            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60 * 20);

            $notificationBuilder = new PayloadNotificationBuilder($notif->title);
            $notificationBuilder->setBody($notif->subtitle)->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['type' => 'order']);

            $optionBuild = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $dataBuild = $dataBuilder->build();
            FCM::sendTo($token_user, $optionBuild, $notification, $dataBuild);

        } elseif ($request->has('buy_by_store')) {
            // jika pembeli adalah store
            $buyer_store = Store::where('id', $data['buy_by_store'])->first();
            $owner_buyer_store = User::where('id', $buyer_store->owner_id)->first();
            $token_owner = $owner_buyer_store->fcm_token;

            $notif = new Notification();
            $notif->sender = $store->id;
            $notif->receiver = $owner_buyer_store->id;
            $notif->type = Notification::$ORDER;
            $notif->title = "Transaksi Pembelian Berhasil!";
            $notif->subtitle = "Selamat "
                . strtoupper($owner_buyer_store->name) . ", transaksi pembelian oleh cabang "
                . strtoupper($buyer_store->name) . " anda sejumlah Rp. "
                . number_format($order->total_price_with_discount, 2) . " pada "
                . strtoupper($store->name) . " telah berhasil dilakukan.";
            $notif->save();

            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60 * 20);

            $notificationBuilder = new PayloadNotificationBuilder($notif->title);
            $notificationBuilder->setBody($notif->subtitle)->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['type' => 'order']);

            $optionBuild = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $dataBuild = $dataBuilder->build();
            FCM::sendTo($token_owner, $optionBuild, $notification, $dataBuild);

            $employees = Employee::where('store_id', $store->id)->get();
            foreach ($employees as $employee) {
                $employee = User::where('id', $employee->user_id)->first();
                $token_employee = $employee->fcm_token;

                $notif = new Notification();
                $notif->sender = $store->id;
                $notif->receiver = $employee->id;
                $notif->type = Notification::$ORDER;
                $notif->title = "Transaksi Pembelian Berhasil!";
                $notif->subtitle = "Selamat "
                    . strtoupper($employee->name) . ", transaksi pembelian oleh cabang "
                    . strtoupper($buyer_store->name) . " milik "
                    . strtoupper($owner_buyer_store->name) . " sejumlah Rp. "
                    . number_format($order->price, 2) . " pada "
                    . strtoupper($store->name) . " telah berhasil dilakukan.";
                $notif->save();

                $optionBuilder = new OptionsBuilder();
                $optionBuilder->setTimeToLive(60 * 20);

                $notificationBuilder = new PayloadNotificationBuilder($notif->title);
                $notificationBuilder->setBody($notif->subtitle)->setSound('default');

                $dataBuilder = new PayloadDataBuilder();
                $dataBuilder->addData(['type' => 'order']);

                $optionBuild = $optionBuilder->build();
                $notification = $notificationBuilder->build();
                $dataBuild = $dataBuilder->build();
                FCM::sendTo($token_employee, $optionBuild, $notification, $dataBuild);
            }
        }

        return response()->json([
            'status' => true,
            'message' => "order created",
            'data' => new OrderResource($order),
        ], 201);
    }
}
