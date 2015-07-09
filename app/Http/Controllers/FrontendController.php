<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Roles;
use App\Category;
use App\libraries\Menu;
use Lang;
use View;
use Route;

class FrontendController extends Controller
{


    public function __construct()
    {
        $title = 'Shop';
        $class_name= substr(__CLASS__,21);
        $action_name=substr(strrchr(Route::currentRouteAction(),"@"),1);
        View::share(array(
            'title'=> $title,
            'class_name'=> $class_name,
            'action_name'=> $action_name,

        ));

    }
    public function index()
    {
        $categories = Category::all()->toArray();
        foreach($categories as $value) {
            $pa=$value['parent'];
            $menuConvert[$pa][]=$value;
        }
        $parent=0;
        $result="";
        Callmenu($menuConvert, $parent, $result);

        View::share(array(

            "menu" => $result,
        ));
       return view('frontend.index');
    }



}

