
Hi {{ $userInfo['username'] }}, <br />

We'd like to personally welcome you to the Laravel 5. Thank you for registering! <br />
Please click below to activate your account:<br />
<a href="{{ URL::to('user/active/' . $userInfo['id']. '/'.$userInfo['keyactive']) }}"><b>Active</b></a>

<br />
----------------------------------------
<br />
SmartOSC - A Smart Open Solution Company