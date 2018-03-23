<html>
<body>
<img style='height:89px' src='http://portal.cartow.ie/public/assets/admin/layout4/img/cartow-login-logo.png'>

<p>{{$first_name}}, Thank you for joining our CarTow.ie agent network. We are delighted to have you on board to join our nationwide network!<br><br>
     Please go to portal.cartow.ie/ to login with your unique Agent ID:</p>
<p>
    In order to create a Desktop short cut to access your portal account,<br><br>
    please follow this link and place the downloadable cartow.exe file on your desktop or pin to start menu.
    <a href="https://portal.cartow.ie/public/uploads/cartow_luncher.exe">https://portal.cartow.ie/public/uploads/cartow_luncher.exe</a>
</p>
<ul>
    <li>Username: {{$username}}</li>
    <li>Password: {{$password}}</li>
</ul>
<br>
<p>
    If you have any difficulties logging in, feel free to contact us on 1850-227869 or info@cartow.ie.
    <br>
    <br>
    Before using our service, please read through our terms and conditions which can be found on our website
    here: <a href='http://portal.cartow.ie/public/terms-and-conditions.pdf'>www.cartow.ie/termsandconditions</a>
</p>


@include('emails.signature')
</body>
</html>

