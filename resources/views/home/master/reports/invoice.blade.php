<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Invoice</title>
    <link rel="stylesheet" href="{{asset('css/invoice.css')}}">
    <style>
        @import url(http://fonts.googleapis.com/css?family=Bree+Serif);
        body, h1, h2, h3, h4, h5, h6{
            font-family: 'Bree Serif', serif;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <h1>
                <a href="https://twitter.com/tahirtaous">
                    <img src="{{ asset('assets/admin/layout4/img/cartow-logo.png') }}" alt="logo" class="logo-default"/>
                </a>
            </h1>
        </div>
        <div class="col-xs-6 text-right">
            <h1>INVOICE</h1>
            <h1><small>Invoice #{{$order->invoice_no}}</small></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>From: <a href="#">CArtow.ie</a></h4>
                </div>
                <div class="panel-body">
                    <p>
                        CarTow.ie, Westpoint Offices, Collinstown Lane, Dublin Airport, Co. Dublin. <br>
                        Phone: 1850-CARTOW (1850-227869)<br>
                        Email: info@cartow.ie
                         <br>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-2 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>To : <a href="#">{{$order->payment_company}}</a></h4>
                </div>
                <div class="panel-body">
                    <p>
                        {{$order->payment_address}} <br>
                        Phone: {{$order->telephone}} <br>
                        Email: {{$order->email}} <br>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h3 class="text-center">Memberships Qty: {{$order->products->count()}} </h3>
            <h3 class="text-center">Total price : &euro;{{number_format($order->total+($order->total*23/100)) }} </h3>
        </div>
    </div>
    <!-- / end client details section -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>
                <h4>Service</h4>
            </th>

            <th>
                <h4>Qty</h4>
            </th>
            <th>
                <h4>Rate/Price</h4>
            </th>
            <th>
                <h4>Sub Total</h4>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->products as $product)
            <tr>
                <td>{{$product->name}}</td>
               
                <td class="text-right">{{$product->quantity}}</td>
                <td class="text-right">&euro;{{$product->price}}</td>
                <td class="text-right">&euro;{{$product->total}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="row text-right">
        <div class="col-xs-2 col-xs-offset-8">
            <p>
                <strong>
                    Sub Total : <br>
                    TAX : <br>
                    Total : <br>
                </strong>
            </p>
        </div>
        <div class="col-xs-2">
            <strong>
                &euro;{{number_format($order->total) }} <br>
                23% <br>
                &euro;{{number_format($order->total+($order->total*23/100)) }} <br>
            </strong>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4>Payment Terms</h4>
                </div>
                <div class="panel-body">
                    {{--<p>Your Name</p>
                    <p>Bank Name</p>
                    <p>SWIFT : --------</p>
                    <p>Account Number : --------</p>
                    <p>IBAN : --------</p>--}}
                    <p> </p>
                    <p>
                        Payment on the 25th of every Month.Your Direct Debit is
                        due for collection on the 25th of September 2015.Thank You </p>
                </div>
            </div>
        </div>
        <div class="col-xs-7">
            <div class="span7">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4>Contact Details</h4>
                    </div>
                    <div class="panel-body">
                        <p>
                            Email : you@example.com <br><br>
                            Mobile : -------- <br> <br>
                            Twitter : <a href="https://twitter.com/tahirtaous">@TahirTaous</a>
                        </p>
                        <h4>Payment should be made by Bank Transfer</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.print();
</script>
</body>
</html>