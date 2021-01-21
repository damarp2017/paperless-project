<?php

namespace App\Http\Controllers\v1\reports;

use App\Exports\InvoiceExport;
use App\Exports\ReportsExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Order;
use App\OrderDetail;
use App\Store;
//use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{
    public function invoice(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $details = new InvoiceResource($order);

        $order_details = OrderDetail::where('order_id', $order->id)->get();
        $array_total_price = (array)null;
        foreach ($order_details as $item) {
            $array_total_price[] = $item->price * $item->quantity;
        }
        $total_price = array_sum($array_total_price);
        $total_price_with_discount = $total_price-$details->discount;

        $pdf = PDF::loadView('exports.invoice', compact(['details', 'total_price', 'total_price_with_discount']));
        $filename = $order->code . ".pdf";
        $filepath = "invoice/" . $filename;

        Storage::put($filepath, $pdf->output());

        return response()->json([
            'status' => true,
            'message' => "OK",
            'data' => [
                'url' => App::environment() == "local" ? URL::to("uploads/".$filepath) : URL::to("public/uploads/".$filepath)
            ]
        ]);

    }

    public function report(Request $request)
    {
        $store_id = $request->store_id;
        $store = Store::where('id', $store_id)->first();
        if (isOwner($store) || isStaff($store)) {
            $filename = "$store->name-" . date_format(now(), 'ymd-His') . ".xlsx";
            $filepath = "download/" . $filename;
            Excel::store(new ReportsExport($store_id), $filepath, null, \Maatwebsite\Excel\Excel::XLSX);

            // Storage::put($filepath, $pdf->output());

            // $excel = Storage::disk('s3')->url($filepath, $filename);
            return response()->json([
                'status' => true,
                'message' => "Ok",
                'data' => [
                    'url' => App::environment() == "local" ? URL::to("uploads/".$filepath) : URL::to("public/uploads/".$filepath)
                ]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "you do not have access",
                'data' => (object)[],
            ], 403);
        }
    }
}
