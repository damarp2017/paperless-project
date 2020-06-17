<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Paperless Invoice</title>

    <style type="text/css" media="all">
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            Paperless
                        </td>

                        <td>
                            Code #: <b>{{ $details->code }}</b><br>
                            Created: <b>{{ $details->created_at->format('d M Y') }}</b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            Seller<br>
                            <b>{{ $details->seller_store->name }}</b><br>
                            {{ $details->seller_store->address }}<br>
                            {{ $details->seller_store->phone }}
                        </td>

                        <td>
                            Buyer<br>
                            @if($details->buyer_user != null)
                                <b>{{ $details->buyer_user->name }}</b><br>
                                {{ $details->buyer_user->email }}
                            @elseif($details->buyer_store != null)
                                <b>{{ $details->buyer_store->name }}</b><br>
                                {{ $details->buyer_store->email }}
                            @else
                                <b>Unregistered User</b>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>
                Item
            </td>
            <td>
                Price
            </td>
        </tr>

        @foreach($details->order_detail as $item)
        <tr class="item">
            <td>
                {{ $item->name }} x {{ $item->quantity }}
            </td>

            <td>
                Rp. {{ number_format($item->price*$item->quantity, 2) }}
            </td>
        </tr>
        @endforeach

        <tr class="total">
            <td></td>

            <td>
                Discount: Rp. {{ number_format($details->discount, 2) }}
            </td>
        </tr>

        <tr class="total">
            <td></td>

            <td>
                Total: Rp. {{ number_format($total_price, 2) }}
            </td>
        </tr>

        <tr class="total">
            <td></td>

            <td>
                Total With Discount: Rp. {{ number_format($total_price_with_discount, 2) }}
            </td>
        </tr>
    </table>
</div>
</body>
</html>
