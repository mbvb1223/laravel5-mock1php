<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Permission;
use App\Roles;
use Illuminate\Routing\Router;
use Lang;
use View;
use Route;
use Mail;

class HomeController extends Controller
{
    public function index(){
//        $user['verification_code']  ='xxxxx';
//
//        Mail::send('mail.hello', ['user' => $user], function($message)
//        {
//
//            $message->subject("dddddWelcome to site name");
//            $message->from("hungprovaidai@gmail.com");
//            $message->to('pckhien@gmail.com');
//        });

//        Mail::send(['html.view', 'text.view'], $data, $callback);
        return view('layouts.admin.master');
    }

}
