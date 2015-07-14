<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Product;
use Illuminate\Http\Request;
use App\Roles;
use App\Category;
use App\libraries\Menu;
use Lang;
use View;
use Route;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{


    public function __construct()
    {
        $title = 'Shop';
        $class_name = substr(__CLASS__, 21);
        $action_name = substr(strrchr(Route::currentRouteAction(), "@"), 1);
        View::share(array(
            'title' => $title,
            'class_name' => $class_name,
            'action_name' => $action_name,

        ));

        /**
         * Get menu header
         */
        $categories = Category::all()->toArray();
        foreach ($categories as $value) {
            $pa = $value['parent'];
            $menuConvert[$pa][] = $value;
        }
        $parent = 0;
        $result = "";
        if ($categories == null) {
            $menuConvert = null;
        }
        Callmenu($menuConvert, $parent, $result);

        View::share(array(

            "menu" => $result,
        ));

    }

    public function index()
    {
        /**
         * Get product demo
         */
        $products = Product::all()->toArray();

        return view('frontend.index')->with([
            "products" => $products,
        ]);
    }

    public function cart()
    {
        if (!Session::has('cart')) {
            $value = null;
            return view('frontend.cart')->with([
                "cartproducts" => $value,
            ]);

        }
        $value = Session::get('cart');


        return view('frontend.cart')->with([
            "cartproducts" => $value,
        ]);


    }

    public function addcart($id)
    {
        //check ID product in Database
        $resultObj = Product::find($id);
        if ($resultObj == null) {
            return;
        }

        $values = Session::get('cart');
        $result = $resultObj->toArray();
        //If don't isset Session['cart'] OR Session['cart']=null
        if (!Session::has('cart') || $values == null) {
            $result['quantity'] = 1;
            Session::put('cart.' . $id, $result);
            return;
        }

        foreach ($values as $key => $value) {
            if ($key == $id) {
                $value['quantity'] += 1;
                Session::put('cart.' . $id, $value);
            } else {
                $result['quantity'] = 1;
                Session::put('cart.' . $id, $result);
            }
        }


    }

    public function destroy($id)
    {
        Session::forget('cart.' . $id);
        return redirect_success('FrontendController@cart', Lang::get('messages.delete_success'));
    }

    public function deleteall()
    {
        if (Session::has('cart')) {
            Session::forget('cart');
            return redirect_success('FrontendController@cart', Lang::get('messages.delete_success'));
        }

    }


}

