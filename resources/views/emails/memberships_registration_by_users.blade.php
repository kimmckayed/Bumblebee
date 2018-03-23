<html>
<body>
<img style='height:89px' src='{{asset('assets/admin/layout4/img/cartow-login-logo.png')}}'>

<p>Dear {{$title}} {{ $last_name}},<br>
    This email is to confirm that you have successfully signed up for an annual CarTow.ie membership with the following
    registration details:</p>
<ul>
    <li>NAME: {{ $first_name}} {{ $last_name}}</li>
    <li>CAR REG: {{ $vehicle_registration}}</li>
    <li>MODEL: {{ $make}} {{ $model}}</li>
</ul>
<p class="Standard">You can view and print the invoice  <a href="{{route('invoice.print',['id'=>dechex($user_id)])}}">here</a> </p>
<p>
    Your CarTow.ie membership will commence on {{ date('d-m-Y', strtotime($start_date)) }} and will last for the duration of one
    year.<br>
    A pack will be posted to you shortly which will contain your unique Member ID and information regarding the benefits
    associated with this membership.<br>
    If you have any queries and would like to contact us, feel free to phone us on 1850-227869 or on info@cartow.ie.<br>
    Thank you for choosing CarTow.ie - Ireland's Premier Breakdown Recovery Company.
</p>

<p>
    Please take the time to read and confirm <a href="http://www.cartow.ie/terms-and-conditions.html"> Terms and Conditions</a>
    <br>
    <br>
    <br>
    If you agree to our Terms & Conditions please click here <a href="{{ url('memberships/accept-terms/'.dechex($user_id)) }}"> Accept terms </a>
</p>


<p>
    Safe driving, <br>
    The CarTow.ie Team
</p>

@include('emails.signature')

</body>
</html>