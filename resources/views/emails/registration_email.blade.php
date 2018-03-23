<html>
<head>
    <title>Login Credentials</title>
</head>
<body>
<p>Dear {{$name}}, <br> Here are your CarTow account details</p>
<table style='border-color: #666;' cellpadding='10'>
    <tr>
        <th>Username</th>
        <th>Password</th>
    </tr>
    <tr>
        <td>{{$username}}</td>
        <td>{{$password}}</td>
    </tr>
</table>
@if($show_monthly_bill_text)
    <p>
        In order to full activate your CarTow.ie portal account, please return the attached forms completed and <br>
        signed to our Financial Controller at david.foley@cartow.ie.
    </p>
@endif


@include('emails.signature')

</body>
</html>