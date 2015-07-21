<?php
namespace App\Http\Controllers;

use App\City;
use App\Color;
use App\ColorSizeNumber;
use App\Order;
use App\Region;
use App\User;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Product;
use App\Category;
use Lang;
use View;
use Route;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{

    use AuthenticatesAndRegistersUsers;


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
        $parent  = 0;
        $topMenu = "";
        if ($categories == null) {
            $menuConvert = null;
        }
        Callmenu($menuConvert, $parent, $topMenu);
        $sidebar = "";
        getSideBarForFrontEnd($menuConvert, $parent, $sidebar);
        View::share(array(
            "menu"    => $topMenu,
            "sidebar" => $sidebar
        ));

    }

    public function index()
    {
        $products = Product::all()->toArray();

        return view('frontend.index')->with([
            "products" => $products,
        ]);
    }

    public function showProductByCategory($stringid){
        $arrayStringId = explode('-', $stringid);
        $idCategory     = intval(array_pop($arrayStringId));

        $objCategory = new Category();
        $allcategory = $objCategory->all()->toArray();

        if(empty($allcategory)){
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.table_category_empty'));
        }

        $arrayCategoryWithMapIdToInfoCatgory = $objCategory->mapIdCategoryToInfoCategory();

        if(!array_key_exists($idCategory,$arrayCategoryWithMapIdToInfoCatgory)){
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.no_id'));
        }

        $objProduct = new Product();
        $dataProductByIdCategory = $objProduct->where('category_id',$idCategory)->paginate(1);

        //Dua vao model & check empty data

//        if(empty($dataProductByIdCategory)){
//            dd($dataProductByIdCategory);
//        }
//        var_dump($dataProductByIdCategory);
//        echo "co"; die();


        return view('frontend.category')->with([
            "dataProductByIdCategory" => $dataProductByIdCategory,

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
        $number     = $allRequest['number'];

        //check ID product in Database
        $product = Product::find($idProduct);
        if (empty($product)) {
            return Redirect::back()->withErrors(Lang::get('messages.not_found_product'));
        }

        //Save Product to session
        $sessionOrder = Session::get('order');
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
                ->withSuccess(Lang::get('messages.add_product_to_cart_successful'));
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

    public function vieworder()
    {
        $sessionOrder = Session::get('order');

        if (empty($sessionOrder)) {
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.cart_empty'));
        }
        $convertAndSortSessionOrder = convertAndSortByKeySessionCart($sessionOrder);
        $objOrder                   = new Order();
        $getViewForCartInFrontEnd   = $objOrder->getViewForCartInFrontEnd($convertAndSortSessionOrder);

        return view('frontend.cart')->with([
            "getViewForCartInFrontEnd" => $getViewForCartInFrontEnd,
        ]);
    }

    public function deletecartitem($idItem)
    {
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

    public function updateorder(Request $request)
    {
        $allRequest   = $request->all();
        $sessionOrder = Session::get('order');

        if (empty($sessionOrder)) {
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.cart_empty'));
        }

        $objOrder = new Order();
        $objOrder->updateNumberForSessionOrder($sessionOrder, $allRequest);
        return redirect()->action('FrontendController@vieworder')
            ->withSuccess(Lang::get('messages.update_success'));
    }

    public function checkout()
    {
        $mapIdCityToArrayRegion = Region::mapIdCityToArrayRegion();
        $sessionUser            = Session::get('user');
        if (!empty($sessionUser)) {
            $idUser   = $sessionUser['id'];
            $objUser  = new Users();
            $infoUser = $objUser->find($idUser);

            $objOrder                             = new Order();
            $getViewFormLoginForCheckout          = $objOrder->getViewFormLoginForCheckout();
            $getViewInfoUserAndAddressForCheckout = $objOrder->getViewInfoUserAndAddressForCheckout($infoUser);


            $sessionOrder = Session::get('order');

            if (empty($sessionOrder)) {
                return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.cart_empty'));
            }
            $convertAndSortSessionOrder   = convertAndSortByKeySessionCart($sessionOrder);
            $getViewCartForSubmitCheckout = $objOrder->getViewCartForSubmitCheckout($convertAndSortSessionOrder);
        } else {
            $objOrder                             = new Order();
            $getViewFormLoginForCheckout          = $objOrder->getViewFormLoginForCheckoutIfNotLogin();
            $getViewInfoUserAndAddressForCheckout = $objOrder->getViewInfoUserAndAddressForCheckoutIfNotLogin();


            $sessionOrder = Session::get('order');

            if (empty($sessionOrder)) {
                return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.cart_empty'));
            }
            $convertAndSortSessionOrder   = convertAndSortByKeySessionCart($sessionOrder);
            $getViewCartForSubmitCheckout = $objOrder->getViewCartForSubmitCheckout($convertAndSortSessionOrder);
        }
        return view('frontend.checkout')->with([
            "getViewInfoUserAndAddressForCheckout" => $getViewInfoUserAndAddressForCheckout,
            "mapIdCityToArrayRegion"               => $mapIdCityToArrayRegion,
            "getViewFormLoginForCheckout"          => $getViewFormLoginForCheckout,
            "getViewCartForSubmitCheckout"         => $getViewCartForSubmitCheckout,
        ]);
    }

    public function submitcheckout(Request $request)
    {
        //if user has login
        $allRequest  = $request->all();
        $sessionUser = Session::get('user');
        if (!empty($sessionUser)) {
            $idUser              = $sessionUser['id'];
            $informationForOrder = $allRequest['information'];
            //update info User
            $objUser              = new Users();
            $updateDataToUserById = $objUser->find($idUser);

            $updateDataToUserById->phone     = $allRequest['phone'];
            $updateDataToUserById->city_id   = $allRequest['city_id'];
            $updateDataToUserById->region_id = $allRequest['region_id'];
            $updateDataToUserById->address   = $allRequest['address'];
            $updateDataToUserById->save();

            //insert to table order
            $sessionOrder = Session::get('order');

            if (empty($sessionOrder)) {
                return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.cart_empty'));
            }
            $convertAndSortSessionOrder = convertAndSortByKeySessionCart($sessionOrder);
            $objOrder                   = new Order();
            $objOrder->submitDataCheckoutToTableOrderAndDetailOrder($convertAndSortSessionOrder, $idUser, $informationForOrder);
        } else {

            //Insert new user
            $dataUserForInsertToDatabase = array(
                'username'  => md5(time()),
                'yourname'  => $allRequest['yourname'],
                'email'     => $allRequest['email'],
                'phone'     => $allRequest['phone'],
                'city_id'   => $allRequest['city_id'],
                'region_id' => $allRequest['region_id'],
                'address'   => $allRequest['address'],
            );

            $objUser = new Users();
            $idUser = $objUser->insertGetId($dataUserForInsertToDatabase);
            $informationForOrder = $allRequest['information'];
            //Insert to Order
            //insert to table order
            $sessionOrder = Session::get('order');

            if (empty($sessionOrder)) {
                return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.cart_empty'));
            }
            $convertAndSortSessionOrder = convertAndSortByKeySessionCart($sessionOrder);
            $objOrder                   = new Order();
            $objOrder->submitDataCheckoutToTableOrderAndDetailOrder($convertAndSortSessionOrder, $idUser, $informationForOrder);

        }

        Session::forget('order');

        return redirect()->action('FrontendController@index')->withSuccess(Lang::get('messages.order_successful'));


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

