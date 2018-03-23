<html>
<body>
<img style='height:89px' src='http://portal.cartow.ie/public/assets/admin/layout4/img/cartow-login-logo.png'>

<p>Dear {{ $title }} {{ $last_name}},<br>
    This email is confirming that {{ $agent['first_name'] or ''}} {{ $agent['last_name'] or ''}} has registered you for
    an annual
    CarTow.ie membership with the following registration details:
</p><br>
<ul>
    <li>NAME: {{ $first_name}} {{ $last_name}}</li>
    <li>CAR REG: {{ $vehicle_registration}}</li>
    <li>MODEL: {{ $make }}{{ $model}}</li>
</ul>
<br>

<p>
    Your CarTow.ie membership will commence on {{ date('d-m-Y', strtotime($start_date)) }} and will last for the duration of one
    year.<br>
    A pack will be posted to you shortly which will contain your unique Member ID and information regarding the benefits
    associated with this membership.<br>
    If you have any queries and would like to contact us, feel free to phone us on 1850-227869 or on info@cartow.ie.
</p>

<p>
    Please take the time to read and confirm <a href="http://www.cartow.ie/terms-and-conditions.html"> Terms and Conditions</a>
    <br>
    <br>
    <br>
    If you agree to our Terms & Conditions please click here <a href="{{ url('memberships/accept-terms/'.dechex($user_id)) }}"> Accept terms </a>
</p>


@include('emails.signature')
</body>
</html>