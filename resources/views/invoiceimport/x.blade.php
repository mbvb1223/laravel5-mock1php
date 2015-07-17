<form class='form-horizontal form-row-seperated'
      action='{{ URL::action('UsersController@update', $result->id) }}' method='Post'
      enctype='multipart/form-data'>
    <input type='hidden' name='_token' value='{{ csrf_token() }}'>