<?php
namespace App\Http\Controllers;

use App\City;
use App\ColorSizeNumber;
use App\DetailOrder;
use App\Http\Requests;
use App\Order;
use App\Product;
use App\Region;
use App\Users;
use Illuminate\Http\Request;
use App\Http\Requests\AddProductToOrderInBackEndRequest;
use Illuminate\Support\Facades\Redirect;
use DB;
use Lang;
use View;
use Route;


class OrderController extends Controller
{
    public function __construct()
    {
        $title       = 'Dashboard - Order';
        $class_name  = substr(__CLASS__, 21);
        $action_name = substr(strrchr(Route::currentRouteAction(), "@"), 1);
        View::share(array(
            'title'       => $title,
            'class_name'  => $class_name,
            'action_name' => $action_name,
        ));
    }

    public function index()
    {
        return view('order.list');
    }

    public function getDataAjax(Request $request)
    {
        $allRequest               = $request->all();
        $objOrder                 = new Order();
        $getDataForPaginationAjax = $objOrder->getDataForPaginationAjax($allRequest);

        return $getDataForPaginationAjax;
    }

    public function edit($idOrder)
    {
        $objOrder      = new Order;
        $dataOrderById = $objOrder->find($idOrder);
        $currentStatus = $dataOrderById->status;

        if ($dataOrderById == null) {
            return redirect()->action('OrderController@index')->withErrors(Lang::get('messages.no_id_order'));
        }

        //========================================Info Order and Detail Order===========================================
        $objDetailOrder             = new DetailOrder();
        $getAllDetailOrderByIdOrder = $objDetailOrder->where('order_id', $idOrder)->get();

        if (empty($getAllDetailOrderByIdOrder)) {
            return redirect()->action('OrderController@index')->withErrors(Lang::get('messages.no_id_order'));
        }
        $getViewAllDetailOrderByIdOrder = $objDetailOrder->getViewAllDetailOrderByIdOrder($getAllDetailOrderByIdOrder);

        //======================================END-Info Order and Detail Order=========================================


        //======================================Form information User==================================================
        //Get Informtion of User
        $mapIdUserToInfoUser = Users::mapIdUserToInfoUser();

        //Get all City for select tag with City selected
        $idUser               = $dataOrderById['user_id'];
        $idCityOfUser         = $mapIdUserToInfoUser[$idUser]['city_id'];
        $getViewSelectTagCity = City::getViewSelectTagCity($idCityOfUser);

        //Get all Region for select tag with Region selected
        $idRegionOfUser         = $mapIdUserToInfoUser[$idUser]['region_id'];
        $getViewSelectTagRegion = Region::getViewSelectTagRegion($idRegionOfUser);

        //Map Id city to array Region for: select city then select region
        $mapIdCityToArrayRegion = Region::mapIdCityToArrayRegion();
        //=======================================END-Form information User=============================================


        // ====================================Add product to Detail order=============================================

        //Get view all product for add product
        $getViewAllProductForSelectTag = Product::getViewAllProductForSelectTag();

        //Select all color of product selected.
        $mapIdProductToAllColorOfThisProduct = ColorSizeNumber::mapIdProductToAllColorOfThisProduct();

        //Select all size of (color, product) selected
        $mapIdColorToAllSizeOfThisProduct = ColorSizeNumber::mapIdColorToAllSizeOfThisProduct();

        //Get number of (color, size, product) selected
        $mapIdSizeToNumberOfThisColorAndThisProduct = ColorSizeNumber::mapIdSizeToNumberOfThisColorAndThisProduct();
        //=====================================END-Add product to Detail order==========================================

        // ========================================Change status for Order==============================================
        $getViewStatusForOrder = Order::getViewStatusForOrder($currentStatus);
        //=====================================END-Change status for Order==============================================


        return view('order.edit')->with([
            'dataOrderById'                              => $dataOrderById,
            'mapIdUserToInfoUser'                        => $mapIdUserToInfoUser,
            'getViewAllDetailOrderByIdOrder'             => $getViewAllDetailOrderByIdOrder,
            'getViewSelectTagCity'                       => $getViewSelectTagCity,
            'getViewSelectTagRegion'                     => $getViewSelectTagRegion,
            'getViewAllProductForSelectTag'              => $getViewAllProductForSelectTag,
            'mapIdProductToAllColorOfThisProduct'        => $mapIdProductToAllColorOfThisProduct,
            'mapIdColorToAllSizeOfThisProduct'           => $mapIdColorToAllSizeOfThisProduct,
            'mapIdSizeToNumberOfThisColorAndThisProduct' => $mapIdSizeToNumberOfThisColorAndThisProduct,
            'mapIdCityToArrayRegion'                     => $mapIdCityToArrayRegion,
            'getViewStatusForOrder'                      => $getViewStatusForOrder,

        ]);
    }

    public function addproduct(AddProductToOrderInBackEndRequest $request)
    {

        $allRequest     = $request->all();
        $idOrder        = $allRequest['order_id'];
        $idProduct      = $allRequest['product_id'];
        $idColor        = $allRequest['color_id'];
        $idSize         = $allRequest['size_id'];
        $objDetailOrder = new DetailOrder();

        //=====================================Check isset Product in Order=============================================
        $checkProductInOrder = $objDetailOrder->where('product_id', $idProduct)
            ->where('color_id', $idColor)
            ->where('size_id', $idSize)
            ->where('order_id', $idOrder)->first();
        //===================================END-Check isset Product in Order===========================================


        //=======================================Update Detail Order====================================================
        DB::beginTransaction();
        if (empty($checkProductInOrder)) {
            $getProductById = Product::find($idProduct);

            if (empty($getProductById)) {
                return redirect()->action('OrderController@edit', $idOrder)->withErrors(Lang::get('messages.no_id'));
            }
            $allRequest['price']        = $getProductById['price'];
            $allRequest['cost']         = $getProductById['cost'];
            $allRequest['price_import'] = $getProductById['price_import'];
            autoAssignDataToProperty($objDetailOrder, $allRequest);
            $objDetailOrder->save();
        } else {
            $idProductIsset              = $checkProductInOrder['id'];
            $getProductInDetailOrderById = $objDetailOrder->find($idProductIsset);
            $getProductInDetailOrderById->number += $allRequest['number'];
            $getProductInDetailOrderById->save();
        }
        //===================================END-Update Detail Order====================================================


        //================Update (total_cost, total_price, total_price_import) in Order=================================
        Order::updateCostPriceAndPriceImportInOrderByIdOrder($idOrder);
        DB::commit();
        //================END-Update (total_cost, total_price, total_price_import) in Order=============================

        return redirect()->action('OrderController@edit', $idOrder)->withSuccess(Lang::get('messages.update_success'));


    }

    public function update(Request $request)
    {

        $allRequest         = $request->all();
        $checkInStockOfItem = $allRequest['checkstock'];
        $idOrder            = $allRequest['id_order'];
        $idUser             = $allRequest['user_id'];
        $selectStatus       = $allRequest['status'];


        //====================================Update information for User===============================================
        $objUser     = new Users;
        $getUserById = $objUser->find($idUser);

        if ($getUserById == null) {
            return redirect()->action('OrderController@edit', $idOrder)->withErrors(Lang::get('messages.no_id'));
        }

        autoAssignDataToProperty($getUserById, $allRequest);
        $getUserById->save();
        //====================================END-Update information for User===========================================


        //===================================Update Information for Order===============================================
        $objOrder                  = new Order();
        $getOrderById              = $objOrder->find($idOrder);
        $getOrderById->information = $allRequest['information'];
        $getOrderById->save();
        //===============================END-Update Information for Order===============================================

        //====================================Update Status for Order===================================================

        $getOrderById  = $objOrder->find($idOrder);
        $CurrentStatus = $getOrderById->status;
        if ($CurrentStatus != $selectStatus) {
            if ($getOrderById == null) {
                return redirect()->action('OrderController@edit', $idOrder)->withErrors(Lang::get('messages.no_id'));
            }
            $flat = true;
            foreach ($checkInStockOfItem as $checkInStock) {
                if ($checkInStock == 0) {
                    $flat = false;
                    break;
                }
            }
            if ($flat) {

                $getOrderById->status = $selectStatus;
                $getOrderById->save();

            } else {
                return redirect()->action('OrderController@edit', $idOrder)->withErrors(Lang::get('messages.can_not_change_status'));
            }
        }
        //====================================END-Update Status for Order===============================================


        return redirect()->action('OrderController@edit', $idOrder)->withSuccess(Lang::get('messages.update_success'));

    }

    public function deleteItemInOrder($id)
    {
        //===================================Delete Item Product in Order===============================================
        $objDetailOrder     = new DetailOrder();
        $getDetailOrderById = $objDetailOrder->find($id);

        if ($getDetailOrderById == null) {
            return Redirect::back()->withErrors(Lang::get('messages.not_id'));
        }
        DB::beginTransaction();
        $getDetailOrderById->delete();
        //===================================END-Delete Item Product in Order===========================================

        //====================Update (total_cost, total_price, total_price_import) in Order=============================
        $idOrder = $getDetailOrderById['order_id'];

        Order::updateCostPriceAndPriceImportInOrderByIdOrder($idOrder);
        DB::commit();
        //================END-Update (total_cost, total_price, total_price_import) in Order=============================


        return Redirect::back()->withSuccess(Lang::get('messages.delete_success'));
    }

}

