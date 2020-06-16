<?php

namespace App\Exports;

use App\Http\Resources\ReportResource;
use App\Http\Resources\TestReportResource;
use App\Order;
use App\OrderDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use function foo\func;

class ReportsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * ReportsExport constructor.
     */
    public function __construct($store_id)
    {
        $this->store_id = $store_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $order = OrderDetail::whereHas('order', function ($query){
            $query->where('sell_by_store', $this->store_id);
        })->get();
        return ReportResource::collection($order);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'buy_by_user',
            'buy_by_store',
            'discount',
            'order_id',
            'product_id',
            'name',
//            'image',
            'price',
            'quantity',
            'created_at',
//            'updated_at'
        ];
    }
}
