<?php
namespace App\Http\Controllers;

use App\City;
use App\Color;
use App\ColorSizeNumber;
use App\Height;
use App\Madein;
use App\Material;
use App\Order;
use App\Region;
use App\Size;
use App\Style;
use App\DetailOrder;
use App\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Cache;
use App\Product;
use App\Category;
use Lang;
use View;
use Route;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{

    use AuthenticatesAndRegistersUsers;


    public function __construct(Request $request)
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
        getSideBarForFrontEnd($menuConvert, $parent, $sidebar, $display = "");

        //===================================View Cart in Index===================================================
        $sessionOrder = Session::get('order');
        if (!empty($sessionOrder)) {
            $convertAndSortSessionOrder = convertAndSortByKeySessionCart($sessionOrder);
            $objOrder                   = new Order();
            $getViewCartInIndexFrontEnd = $objOrder->getViewCartInIndexFrontEnd($convertAndSortSessionOrder)[0];
            $countSessionCart           = count($sessionOrder);
            $totalCost                  = $objOrder->getViewCartInIndexFrontEnd($convertAndSortSessionOrder)[1];
        } else {
            $getViewCartInIndexFrontEnd = null;
            $countSessionCart           = 0;
            $totalCost                  = 0;
        }
        //===================================END-View Cart in Index===================================================

        $getViewUserInIndexFrontEnd = Users::getViewUserInIndexFrontEnd();

        View::share(array(
            "menu"                       => $topMenu,
            "sidebar"                    => $sidebar,
            'getViewCartInIndexFrontEnd' => $getViewCartInIndexFrontEnd,
            "countSessionCart"           => $countSessionCart,
            "totalCost"                  => $totalCost,
            "getViewUserInIndexFrontEnd" => $getViewUserInIndexFrontEnd,
        ));

    }

    public function index()
    {
        //========================================Get 7 product new=====================================================
        $objProduct        = new Product();
        $newProducts       = $objProduct->where('status', Product::STATUS_SHOW)->skip(0)->take(7)->orderBy('id', 'desc')->get()->toArray();
        $getViewNewProduct = $objProduct->getViewProductByArrayProduct($newProducts);
        //========================================END-Get 7 product new=================================================

        //===================================Get 10 product for Men=====================================================
        $objCategory = new Category();
        //get all childrent for MEN
        $getAnyIdChildrentFromIdCategoryMen = null;
        $idCategoryMen                      = Category::MEN;
        $allCategory                        = $objCategory->all()->toArray();
        $objCategory->getAnyIdChildrentFromIdCategory($idCategoryMen, $allCategory, $getAnyIdChildrentFromIdCategoryMen);
        $allProductForMen  = $objProduct->getTenProducByArrayIdCategory($getAnyIdChildrentFromIdCategoryMen);
        $getViewProductMen = $objProduct->getViewProductByArrayProduct($allProductForMen);

        //===================================END-Get 10 product for Men=================================================

        //===================================Get 10 product for Women===================================================
        $getAnyIdChildrentFromIdCategoryWomen = null;
        $idCategoryWomen                      = Category::WOMEN;
        $objCategory->getAnyIdChildrentFromIdCategory($idCategoryWomen, $allCategory, $getAnyIdChildrentFromIdCategoryWomen);
        $allProductForWomen  = $objProduct->getTenProducByArrayIdCategory($getAnyIdChildrentFromIdCategoryWomen);
        $getViewProductWomen = $objProduct->getViewProductByArrayProduct($allProductForWomen);
        //===================================END-Get 10 product for Women===============================================

        //==========================================Get hot product=====================================================
        $objOrder            = new Order();
        $getDataOrderOk      = $objOrder
            ->where('created_at', '>=', Carbon::now()->subDay(15))
            ->where('created_at', '<=', Carbon::now())
            ->where('status', Order::OK)
            ->get();
        $getArrayDataOrderOk = $getDataOrderOk->toArray();
        if (!empty($getArrayDataOrderOk)) {
            $objDetailOrder = new DetailOrder();
            $objDetailOrder = $objDetailOrder->selectRaw('detail_order.product_id,
            product.*,
            sum(detail_order.number) as sum')
                ->leftJoin('product', 'product.id', '=', 'detail_order.product_id');
            foreach ($getArrayDataOrderOk as $item) {
                $objDetailOrder = $objDetailOrder->orwhere('detail_order.order_id', $item['id']);
            }
            $getHotProduct     = $objDetailOrder->groupBy('detail_order.product_id')
                ->orderBy('sum', 'desc')
                ->take(9)
                ->get()
                ->toArray();
            $getViewHotProduct = $objProduct->getViewProductByArrayProduct($getHotProduct);
        } else {
            $getViewHotProduct = null;
        }
        //============================================END-Get hot product===============================================


        return view('frontend.index')->with([
            "newProducts"         => $newProducts,
            "getViewProductMen"   => $getViewProductMen,
            "getViewProductWomen" => $getViewProductWomen,
            "getViewNewProduct"   => $getViewNewProduct,
            'getViewHotProduct'   => $getViewHotProduct,
        ]);
    }

    public function getProductForFastView(Request $request)
    {
        //====================================Get information of Product================================================
        $allRequest     = $request->all();
        $idProduct      = $allRequest['id'];
        $objProduct     = new Product();
        $getProductById = $objProduct->select('product.*', 'selloff.selloff_value', 'style.style_name', 'madein.madein_name', 'material.material_name', 'height.height_value')
            ->join('style', 'style.id', '=', 'product.style_id')
            ->join('selloff', 'selloff.id', '=', 'product.selloff_id')
            ->join('madein', 'madein.id', '=', 'product.madein_id')
            ->join('material', 'material.id', '=', 'product.material_id')
            ->join('height', 'height.id', '=', 'product.height_id')
            ->where('product.id', $idProduct)->first();

        if (empty($getProductById)) {
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.id_product_not_isset'));
        }

        //check product new
        $checkNew = Carbon::now()->subDay(Product::CHECK_NEW) < $getProductById['created_at'];
        if ($checkNew == true) {
            $stickNew = "<div class='sticker sticker-new'></div>";
        } else {
            $stickNew = null;
        }

        //check sell_off
        if ($getProductById['selloff_id'] != 0) {
            $price     = number_format($getProductById['price'], 2);
            $checkSale = "<div class='sticker sticker-sale'></div>";
        } else {
            $price     = null;
            $checkSale = null;
        }
        $linkDetailProduct = url("/") . "/product/" . change_alias($getProductById->name_product) . "-" . $getProductById->id;
        //====================================END-Get information of Product============================================

        //====================================Check Product in Stock====================================================

        $getProductById = $getProductById->toArray();

        //check product in table color_size_number (check product in warehouse)
        $colorSizeNumber                  = new ColorSizeNumber();
        $getProductInTableColorSizeNumber = $colorSizeNumber->where('product_id', $idProduct)
            ->where('number', '>', 0)->get()->toArray();

        if ($getProductInTableColorSizeNumber == null) {
            $getViewColorForSelectTag       = Color::getViewAllColorForSelectTag();
            $getViewSizeForSelectTag        = Size::getViewAllSizeForSelectTag();
            $getSizeFromColorForThisProduct = null;
            $mapIdSizeToInformationSize     = null;
            $vailability                    = Lang::get('messages.not_in_stock');

        } else {
            foreach ($getProductInTableColorSizeNumber as $color) {
                $getSizeFromColorForThisProduct[$color['color_id']][] = $color['size_id'];
            }
            $getColorForThisProduct     = array_keys($getSizeFromColorForThisProduct);
            $getViewColorForSelectTag   = Color::getViewColorForSelectTag($getColorForThisProduct);
            $getViewSizeForSelectTag    = null;
            $mapIdSizeToInformationSize = Size::mapIdSizeToInformationSize();
            $vailability                = Lang::get('messages.in_stock');
        }
        //====================================END-Check Product in Stock================================================


        return json_encode($data = array([
            "product"                        => $getProductById,
            'getViewColorForSelectTag'       => $getViewColorForSelectTag,
            'getSizeFromColorForThisProduct' => $getSizeFromColorForThisProduct,
            'getViewSizeForSelectTag'        => $getViewSizeForSelectTag,
            'mapIdSizeToInformationSize'     => $mapIdSizeToInformationSize,
            'vailability'                    => $vailability,
            'stickNew'                       => $stickNew,
            'price'                          => $price,
            'checkSale'                      => $checkSale,
            "linkDetailProduct"              => $linkDetailProduct,

        ]));

    }

    public function showProductByCategory(Request $request, $stringid)
    {
        $allRequest = $request->all();

        //get Id category
        $arrayStringId = explode('-', $stringid);
        $idCategory    = intval(array_pop($arrayStringId));

        $objCategory = new Category();

        //check id isset in database
        $checkIdCategoryIssetInTable = $objCategory->find($idCategory);
        if (empty($checkIdCategoryIssetInTable)) {
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.no_id'));
        }

        //get any id category parent
        $allCategory = $objCategory->all()->toArray();

        $getAnyIdParentFromIdProduct[] = $idCategory;

        $objCategory->getAnyIdParentFromIdCategory($idCategory, $allCategory, $getAnyIdParentFromIdProduct);


        $objProduct              = new Product();
        $dataProductByIdCategory = $objProduct->where('category_id', $idCategory);
        //===========================================Filter=============================================================
        $arraySort = array();
        if (isset($allRequest['madein']) && $allRequest['madein'] != 0) {
            $filterMadein            = $allRequest['madein'];
            $dataProductByIdCategory = $dataProductByIdCategory->where('madein_id', $filterMadein);
            $arraySort['madein']     = $filterMadein;
        } else {
            $filterMadein = 0;
        }
        if (isset($allRequest['style']) && $allRequest['style'] != 0) {
            $filterStyle             = $allRequest['style'];
            $dataProductByIdCategory = $dataProductByIdCategory->where('style_id', $filterStyle);
            $arraySort['style']      = $filterStyle;
        } else {
            $filterStyle = 0;
        }
        if (isset($allRequest['material']) && $allRequest['material'] != 0) {
            $filterMaterial          = $allRequest['material'];
            $dataProductByIdCategory = $dataProductByIdCategory->where('material_id', $filterMaterial);
            $arraySort['material']   = $filterMaterial;
        } else {
            $filterMaterial = 0;
        }
        if (isset($allRequest['height']) && $allRequest['height'] != 0) {
            $filterHeight            = $allRequest['height'];
            $dataProductByIdCategory = $dataProductByIdCategory->where('height_id', $filterHeight);
            $arraySort['height']     = $filterHeight;
        } else {
            $filterHeight = 0;
        }
        if (isset($allRequest['cost']) && $allRequest['cost'] == 0) {
            $dataProductByIdCategory = $dataProductByIdCategory->orderBy('cost', 'desc');
            $arraySort['cost']       = 0;
        }
        if (isset($allRequest['cost']) && $allRequest['cost'] == 1) {
            $dataProductByIdCategory = $dataProductByIdCategory->orderBy('cost', 'asc');
            $arraySort['cost']       = 1;
        } else {
            $arraySort['cost'] = null;
        }
        $getViewAllMadeInForSelectTag   = Madein::getViewAllMadeInForSelectTag($filterMadein);
        $getViewAllStyleForSelectTag    = Style::getViewAllStyleForSelectTag($filterStyle);
        $getViewAllMaterialForSelectTag = Material::getViewAllMaterialForSelectTag($filterMaterial);
        $getViewAllHeightForSelectTag   = Height::getViewAllHeightForSelectTag($filterHeight);
        //===========================================END-Filter=============================================================

        //dd($dataProductByIdCategory);
        $dataProductByIdCategory = $dataProductByIdCategory->paginate(9);


        return view('frontend.category')->with([
            "dataProductByIdCategory"        => $dataProductByIdCategory,
            "getViewAllMadeInForSelectTag"   => $getViewAllMadeInForSelectTag,
            "getViewAllStyleForSelectTag"    => $getViewAllStyleForSelectTag,
            "getViewAllMaterialForSelectTag" => $getViewAllMaterialForSelectTag,
            "getViewAllHeightForSelectTag"   => $getViewAllHeightForSelectTag,
            'arraySort'                      => $arraySort,


        ]);
    }

    public function searchProduct(Request $request)
    {
        $allRequest = $request->all();

        if (!isset($allRequest['key']) || $allRequest['key'] == null) {
            return redirect()->action('FrontendController@index');
        }
        $searchString = $allRequest['key'];

        $objProduct          = new Product();
        $dataProductBySearch = $objProduct->where('name_product', 'LIKE', '%' . $searchString . '%')
            ->orwhere('key_product', 'LIKE', '%' . $searchString . '%');

        //===========================================Filter=============================================================
        $arraySort = array();
        if (isset($allRequest['madein']) && $allRequest['madein'] != 0) {
            $filterMadein        = $allRequest['madein'];
            $dataProductBySearch = $dataProductBySearch->where('madein_id', $filterMadein);
            $arraySort['madein'] = $filterMadein;
        } else {
            $filterMadein = 0;
        }
        if (isset($allRequest['style']) && $allRequest['style'] != 0) {
            $filterStyle         = $allRequest['style'];
            $dataProductBySearch = $dataProductBySearch->where('style_id', $filterStyle);
            $arraySort['style']  = $filterStyle;
        } else {
            $filterStyle = 0;
        }
        if (isset($allRequest['material']) && $allRequest['material'] != 0) {
            $filterMaterial        = $allRequest['material'];
            $dataProductBySearch   = $dataProductBySearch->where('material_id', $filterMaterial);
            $arraySort['material'] = $filterMaterial;
        } else {
            $filterMaterial = 0;
        }
        if (isset($allRequest['height']) && $allRequest['height'] != 0) {
            $filterHeight        = $allRequest['height'];
            $dataProductBySearch = $dataProductBySearch->where('height_id', $filterHeight);
            $arraySort['height'] = $filterHeight;
        } else {
            $filterHeight = 0;
        }
        if (isset($allRequest['cost']) && $allRequest['cost'] == 0) {
            $dataProductBySearch = $dataProductBySearch->orderBy('cost', 'desc');
            $arraySort['cost']   = 0;
        }
        if (isset($allRequest['cost']) && $allRequest['cost'] == 1) {
            $dataProductBySearch = $dataProductBySearch->orderBy('cost', 'asc');
            $arraySort['cost']   = 1;
        } else {
            $arraySort['cost'] = null;
        }
        $getViewAllMadeInForSelectTag   = Madein::getViewAllMadeInForSelectTag($filterMadein);
        $getViewAllStyleForSelectTag    = Style::getViewAllStyleForSelectTag($filterStyle);
        $getViewAllMaterialForSelectTag = Material::getViewAllMaterialForSelectTag($filterMaterial);
        $getViewAllHeightForSelectTag   = Height::getViewAllHeightForSelectTag($filterHeight);
        //=======================================END-Filter=============================================================

        $dataProductBySearch = $dataProductBySearch->paginate(9);

        //appending key serach
        $arraySort['key'] = $searchString;

        return view('frontend.search')->with([
            "dataProductBySearch"            => $dataProductBySearch,
            "getViewAllMadeInForSelectTag"   => $getViewAllMadeInForSelectTag,
            "getViewAllStyleForSelectTag"    => $getViewAllStyleForSelectTag,
            "getViewAllMaterialForSelectTag" => $getViewAllMaterialForSelectTag,
            "getViewAllHeightForSelectTag"   => $getViewAllHeightForSelectTag,
            'arraySort'                      => $arraySort,
        ]);
    }

    public function product($stringid)
    {
        //====================================Get information of Product================================================

        $idProduct      = convertStringUrlToId($stringid);
        $objProduct     = new Product();
        $getProductById = $objProduct->select('product.*', 'selloff.selloff_value', 'style.style_name', 'madein.madein_name', 'material.material_name', 'height.height_value')
            ->leftJoin('style', 'style.id', '=', 'product.style_id')
            ->leftJoin('selloff', 'selloff.id', '=', 'product.selloff_id')
            ->leftJoin('madein', 'madein.id', '=', 'product.madein_id')
            ->leftJoin('material', 'material.id', '=', 'product.material_id')
            ->leftJoin('height', 'height.id', '=', 'product.height_id')
            ->where('product.id', $idProduct)->first();
        if (empty($getProductById)) {
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.id_product_not_isset'));
        }

        //check product new
        $checkNew = Carbon::now()->subDay(Product::CHECK_NEW) < $getProductById['created_at'];
        if ($checkNew == true) {
            $stickNew = "<div class='sticker sticker-new'></div>";
        } else {
            $stickNew = null;
        }

        //check sell_off
        if ($getProductById['selloff_id'] != 0) {
            $price     = number_format($getProductById['price'], 2);
            $checkSale = "<div class='sticker sticker-sale'></div>";
        } else {
            $price     = null;
            $checkSale = null;
        }

        //====================================END-Get information of Product============================================

        //====================================Check Product in Stock====================================================

        $getProductById = $getProductById->toArray();

        //check product in table color_size_number (check product in warehouse)
        $colorSizeNumber                  = new ColorSizeNumber();
        $getProductInTableColorSizeNumber = $colorSizeNumber->where('product_id', $idProduct)
            ->where('number', '>', 0)->get()->toArray();

        if ($getProductInTableColorSizeNumber == null) {
            $getViewColorForSelectTag       = Color::getViewAllColorForSelectTag();
            $getViewSizeForSelectTag        = Size::getViewAllSizeForSelectTag();
            $getSizeFromColorForThisProduct = null;
            $mapIdSizeToInformationSize     = null;
            $vailability                    = Lang::get('messages.not_in_stock');

        } else {
            foreach ($getProductInTableColorSizeNumber as $color) {
                $getSizeFromColorForThisProduct[$color['color_id']][] = $color['size_id'];
            }
            $getColorForThisProduct     = array_keys($getSizeFromColorForThisProduct);
            $getViewColorForSelectTag   = Color::getViewColorForSelectTag($getColorForThisProduct);
            $getViewSizeForSelectTag    = null;
            $mapIdSizeToInformationSize = Size::mapIdSizeToInformationSize();
            $vailability                = Lang::get('messages.in_stock');
        }
        //====================================END-Check Product in Stock================================================

        //=========================================Get Product relation=================================================

        $idCategory                               = $getProductById['category_id'];
        $objProduct                               = new Product();
        $dataProductByIdCategory                  = $objProduct->where('category_id', $idCategory)->take(5)->orderByRaw("RAND()")->get();
        $getViewFiveProductRelationForPageProduct = $objProduct->getViewFiveProductRelationForPageProduct($dataProductByIdCategory);

        //=====================================END-Get Product relation=================================================

        //=========================================Set Title for Page===================================================
        $title = $stringid;
        View::share(array(
            'title' => $title,
        ));
        //=====================================END-Set Title for Page===================================================


        return view('frontend.product')->with([
            "product"                                  => $getProductById,
            'getViewColorForSelectTag'                 => $getViewColorForSelectTag,
            'getSizeFromColorForThisProduct'           => $getSizeFromColorForThisProduct,
            'getViewSizeForSelectTag'                  => $getViewSizeForSelectTag,
            'mapIdSizeToInformationSize'               => $mapIdSizeToInformationSize,
            'vailability'                              => $vailability,
            'getViewFiveProductRelationForPageProduct' => $getViewFiveProductRelationForPageProduct,
            'stickNew'                                 => $stickNew,
            'price'                                    => $price,
            'checkSale'                                => $checkSale,

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
        return Redirect::back()
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
            $objUser                     = new Users();
            $idUser                      = $objUser->insertGetId($dataUserForInsertToDatabase);
            $informationForOrder         = $allRequest['information'];
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

    public function contact()
    {
        return view('frontend.contact')->with([

        ]);
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

