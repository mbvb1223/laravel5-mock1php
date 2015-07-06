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

class HomeController extends Controller
{
    public function index(){
        return view('layouts.admin.master');
    }

}
