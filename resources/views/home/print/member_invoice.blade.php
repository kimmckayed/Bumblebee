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
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <p>
                CarTow beak down assistant <br>
                Westpoint Offices <br>
                Collinstown Lane<br>
                Dublin Airport<br>
                Dublin<br>
                <br>
                Tel : 1850-CARTOW (1850-227869)<br>
                <br>
                <br>
                <br>
                <strong>VAT Reg No : 3287061FH</strong>
            </p>
        </div>
        <div class="col-xs-6 text-right">
            <h1><small>Invoice #{{$order->id}}</small></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        Name : {{$order->first_name}}  {{$order->last_name}}<br>
                        Address : {{$order->address_line_1}}<br>
                        {{$order->address_line_2}}<br>
                        City : {{$order->town}}<br>
                        Postal code :{{$order->postal_code}}<br>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-2 ">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        Invoice No:  {{$order->id}} <br>
                        Invoice Date: {{$order->created_at}} <br>
                        Membership Id: {{$order->membership_id}} <br>
                        vehicle Reg: {{$order->vehicle_registration}} <br>
                        Start date: {{$order->start_date}} <br>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h3 class="text-center">Total price : &euro;{{number_format($order->membership_detail->price,2)}} </h3>
        </div>
    </div>
    <!-- / end client details section -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>
                <h4>Description </h4>
            </th>


            <th>
                <h4>promo discount</h4>
            </th>
            <th>
                <h4> Net Price</h4>
            </th>

            <th>
                <h4> VAT 23%</h4>
            </th>

            <th>
                <h4> Gross Price</h4>
            </th>
        </tr>
        </thead>
        <tbody>

            <tr>
                <td>{{$order->membership_detail->membership_name}}</td>

                <td class="text-right">&euro;0</td>
                <td class="text-right">&euro;{{number_format($order->membership_detail->price/((23/100)+1),2)}}</td>
                <td class="text-right">&euro;{{number_format(($order->membership_detail->price/((23/100)+1))*23/100,2)}}</td>
                <td class="text-right">&euro;{{number_format($order->membership_detail->price,2)}}</td>
            </tr>


        </tbody>
    </table>
    <div class="row text-right">
        <div class="col-xs-2 col-xs-offset-8">
            <p>
                <strong>
                    Total Discount : <br>
                    Total Net Amount : <br>
                    Total TAX : <br>
                    Total : <br>
                </strong>
            </p>
        </div>
        <div class="col-xs-2">
            <strong>
                &euro;0<br>
                &euro;{{number_format($order->membership_detail->price/((23/100)+1),2)}} <br>
                &euro;{{number_format(($order->membership_detail->price/((23/100)+1))*23/100,2)}} <br>
                &euro;{{number_format($order->membership_detail->price,2)}} <br>
            </strong>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4>Payment Terms</h4>
                </div>
                <div class="panel-body">


                    <p>
                       Your payment has been successfully processed with thanks. cartow.ie payment are securely handled by stripe payment systems  </p>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
   // window.print();
</script>
</body>
</html>