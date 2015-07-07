
Hi {{ $userInfo['username'] }}, <br /><br />

We'd like to personally welcome you to the Laravel 5. Thank you for registering! <br /><br />
Please click below to activate your account:<br />
<a href="{{ URL::to('user/active/' . $userInfo['id']. '/'.$userInfo['keyactive']) }}" target="_blank"><b>Active now!</b></a>
<br />
<br />
----------------------------------------
<br />
SmartOSC - A Smart Open Solution Company