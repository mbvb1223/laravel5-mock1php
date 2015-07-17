<?php
namespace App\Http\Controllers;

use App\Color;
use App\ColorSizeNumber;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Product;
use App\Category;
use Lang;
use View;
use Route;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{


    public function __construct()
    {
        $title       = 'Shop';
        $class_name  = substr(__CLASS__, 21);
        $action_name = substr(strrchr(Route::currentRouteAction(), "@"), 1);
        View::share(array(
            'title'       => $title,
            'class_name'  => $class_name,
            'action_name' => $action_name,

        ));

        /**
         * Get menu header
         */
        $categories = Category::all()->toArray();
        foreach ($categories as $value) {
            $pa                 = $value['parent'];
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
        $products = Product::all()->toArray();

        return view('frontend.index')->with([
            "products" => $products,
        ]);
    }

    public function product($stringid)
    {

        $arrayStringId = explode('-', $stringid);
        $idProduct     = intval(array_pop($arrayStringId));

        $product = Product::find($idProduct);
        if (empty($product)) {
            return;
        }
        $product   = $product->toArray();
        $idProduct = $product['id'];


        $colorSizeNumber                  = new ColorSizeNumber();
        $getProductInTableColorSizeNumber = $colorSizeNumber->where('product_id', $idProduct)
            ->where('number', '>', 0)->get()->toArray();

        if ($getProductInTableColorSizeNumber == null) {
            return "x";
        } else {
            foreach ($getProductInTableColorSizeNumber as $color) {

                $getSizeFromColorForThisProduct[$color['color_id']][] = $color['size_id'];

            }
        }
        $getColorForThisProduct = array_keys($getSizeFromColorForThisProduct);
        $objColor               = new Color();
        $mapIdToInfoColor       = $objColor->mapIdToInfoColor();


//        var_dump($getColorForThisProduct);
//        var_dump($getSizeFromColorForThisProduct);
//        die();

        return view('frontend.product')->with([
            "product"                        => $product,
            'getColorForThisProduct'         => $getColorForThisProduct,
            'mapIdToInfoColor'               => $mapIdToInfoColor,
            'getSizeFromColorForThisProduct' => $getSizeFromColorForThisProduct,
        ]);
    }

    public function addorder(Request $requests)
    {
        $allRequest = $requests->all();
        $idProduct  = $allRequest['id'];
        $idColor    = $allRequest['color_id'];
        $idSize     = $allRequest['size_id'];
        $number = $allRequest['number'];

        //check ID product in Database
        $product = Product::find($idProduct);
        if (empty($product)) {
            return Redirect::back()->withErrors(Lang::get('messages.not_found_product'));
        }

        //Save Product to session
        $sessionOrder      = Session::get('order');
        $keyOfOrder   = $idProduct . "|" . $idColor . "|" . $idSize;
        //check not isset SessionOrder OR SessionOrder null
        if (!Session::has('order') || $sessionOrder == null) {
            $valueOfOrder = array(
                'product_id' => intval($idProduct),
                'color_id'   => intval($idColor),
                'size_id'    => intval($idSize),
                'number'     => intval($number)
            );
            Session::put('order.' . $keyOfOrder, $valueOfOrder);
            return Redirect::back()
                ->withSuccess(Lang::get('messages.add_product_to_order_successful'));
        }

        //If isset of $sessionCart AND $sessionCart != null
        if (array_key_exists($keyOfOrder, $sessionOrder)) {
                $sessionOrder[$keyOfOrder]['number'] += $number;
            Session::put('order.' . $keyOfOrder, $sessionOrder[$keyOfOrder]);
        } else {
            $valueOfOrder = array(
                    'product_id' => intval($idProduct),
                    'color_id'   => intval($idColor),
                    'size_id'    => intval($idSize),
                    'number'     => intval($number)
                );
            Session::put('order.' . $keyOfOrder, $valueOfOrder);
        }
        return Redirect::back()
            ->withSuccess(Lang::get('messages.add_product_to_cart_successful'));

    }

    public function vieworder(){
        $sessionOrder = Session::get('order');

        if (empty($sessionOrder)) {
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.cart_empty'));
        }
        $convertAndSortSessionOrder = convertAndSortByKeySessionCart($sessionOrder);
        $objOrder = new Order();
        $getViewForCartInFrontEnd = $objOrder->getViewForCartInFrontEnd($convertAndSortSessionOrder);

        return view('frontend.cart')->with([
            "getViewForCartInFrontEnd" => $getViewForCartInFrontEnd,
        ]);
    }

    public function deletecartitem($idItem){
        $sessionOrder = Session::get('order');

        if (empty($sessionOrder)) {
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.cart_empty'));
        }
        if (!array_key_exists($idItem, $sessionOrder)) {
            return redirect()->action('FrontendController@view')->withErrors(Lang::get('messages.this_product_not_isset_in_session'));
        }

        Session::forget('order.' . $idItem);
        return redirect()->action('FrontendController@vieworder')
            ->withSuccess(Lang::get('messages.delete_success'));
    }

    public function updateorder(Request $request){
        dd($request->all());
        $sessionOrder = Session::get('order');

        if (empty($sessionOrder)) {
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.cart_empty'));
        }
        if (!array_key_exists($idItem, $sessionOrder)) {
            return redirect()->action('FrontendController@view')->withErrors(Lang::get('messages.this_product_not_isset_in_session'));
        }

        Session::forget('order.' . $idItem);
        return redirect()->action('FrontendController@vieworder')
            ->withSuccess(Lang::get('messages.delete_success'));
    }

    public function destroy($id)
    {
        Session::forget('cart.' . $id);
        return redirect_success('FrontendController@cart', Lang::get('messages.delete_success'));
    }

    public function deleteall()
    {
        if (Session::has('order')) {
            Session::forget('order');
            return redirect_success('FrontendController@cart', Lang::get('messages.delete_success'));
        }

    }
    public function test()
    {
        $values = Session::get('order');
        dd($values);
    }

    public function test2()
    {
        if (Session::has('order')) {
            Session::forget('order');

        }
    }


}

