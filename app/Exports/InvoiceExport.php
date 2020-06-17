<?php

namespace App\Exports;

use App\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.invoice', compact([
            'order' => Order::all()
        ]));
    }
}
