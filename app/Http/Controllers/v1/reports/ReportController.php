<?php

namespace App\Http\Controllers\v1\reports;

use App\Exports\ReportsExport;
use App\Http\Controllers\Controller;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $store_id = $request->store_id;
        $store = Store::where('id', $store_id)->first();
        $filename = "$store->name-" . date_format(now(), 'ymd-His') . ".xlsx";
        $filepath = "download/" . $filename;
        Excel::store(new ReportsExport($store_id), $filepath,'s3', \Maatwebsite\Excel\Excel::XLSX);
        $excel = Storage::disk('s3')->url($filepath, $filename);
        return response()->json([
            'status' => true,
            'message' => "Ok",
            'data' => [
                'url' => $excel
            ]
        ]);
    }
}
