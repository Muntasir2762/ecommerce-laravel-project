<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .invoice-table th, td {
            border: 1px solid #000000;
        }
        .invoice-table th {
            padding: 10px;
            font-size: 20px;
            color: #000;
            font-weight: 700;
        }
        .invoice-table td {
            font-size: 18px;
            font-weight: 600;
            padding: 10px;
        }
    </style>
</head>

<body>
    @foreach ($orders as $order)
        <div style="display: flex;align-items: center;justify-content: space-between;margin-bottom: 25px">
        <div style="width: 35%">
            <img src="{{$globalSiteSettings->logo}}" style="max-height: 100px; width: 100px;" alt="logo" />
        </div>
        <div style="width: 65%">
            <p style="margin-bottom: 0;font-size: 18px;font-weight: 600;color: #000;">
                আগে পণ্য দেখে নিন, তারপরে ডেলিভারি ম্যানকে টাকা দিন।
            </p>
        </div>
    </div>

    <div style="display: flex;justify-content: space-between;">
        <div style="width: 33.33%;margin-right: 20px;">
            <p style="font-size: 18px;font-family: 'Open Sans', sans-serif;color: #000;margin-bottom: 5px;border-bottom: 1px solid #ddd;font-weight: 700;">
                Customer Info
            </p>
            <p style="font-size: 18px;font-family: 'Open Sans', sans-serif;color: #000;font-weight: 600;margin-bottom: 0;">
                {{$order->name}}<br> {{$order->phone}}<br> {{$order->address}}
            </p>
        </div>
        <div style="width: 33.33%;margin-right: 40px;">
            <p style="font-size: 18px;font-family: 'Open Sans', sans-serif;color: #000;margin-bottom: 5px;border-bottom: 1px solid #ddd;font-weight: 700;">
                Company Info
            </p>
            <p style="font-size: 18px;font-family: 'Open Sans', sans-serif;color: #000;font-weight: 600;margin-bottom: 0;">
                Ecommerce.com<br>For any query call: {{$globalSiteSettings->phone}}<br>{{$globalSiteSettings->address}}
            </p>
        </div>
        <div style="width: 33.33%;margin-top: 30px;">
            <p style="font-size: 18px; margin-bottom:2px"><b>Order Number: {{$order->invoice_number}}</b></p>
            <p style="font-size: 18px; margin-bottom:2px"><b>Order Date: {{ $order->created_at->format('d-m-y') }}</b></p>
        </div>
    </div>

    <!-- Header -->
    <table class="invoice-table" style="margin-bottom: 0px; border: 1px solid #000;width: 100%;margin-top: 15px;">
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Size</th>
            <th>Color</th>
        </tr>
        @foreach ($order->orderDetails as $detail)
        <tr>
            <td style="width: 60%">{{$detail->product->name}}</td>
            <td style="width: 20%">{{$detail->qty}}</td>
            <td style="width: 20%;">{{$detail->qty*$detail->price}} Tk.</td>
            <td style="width: 20%;">Size: {{$detail->size}}</td>
            <td style="width: 20%;">Color: {{$detail->color}}</td>
        </tr>
        @endforeach

        <tr>
            <td></td>
            <td><strong>Subtotal</strong></td>
            <td><strong>{{$order->price-$order->charge}} Tk.</strong></td>
        </tr>
        {{-- <tr>
            <td></td>
            <td><strong>Discount</strong></td>
            <td><strong>200 Tk.</strong></td>
        </tr> --}}
        <tr>
            <td></td>
            <td><strong>Delivery Charge</strong></td>
            <td><strong>{{$order->charge}} Tk.</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Total</strong></td>
            <td><strong>{{$order->price}} Tk.</strong></td>
        </tr>
    </table>
    <!-- /Header -->
    <hr>
    @endforeach

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
