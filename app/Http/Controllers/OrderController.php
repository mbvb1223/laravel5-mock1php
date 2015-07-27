<?php
namespace App\Http\Controllers;

use App\City;
use App\ColorSizeNumber;
use App\DetailOrder;
use App\Http\Requests;
use App\Http\Requests\UpdateOrderRequest;
use App\Order;
use App\Product;
use App\Region;
use App\Users;
use DateTime;
use Illuminate\Support\Facades\Mail;
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
            'idUser'                                     => $idUser,

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

    public function update(UpdateOrderRequest $request)
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
                if ($selectStatus == Order::OK) {
                    $objDetailOrder             = new DetailOrder();
                    $getAllDetailOrderByIdOrder = $objDetailOrder->where('order_id', $idOrder)->get();
                    $objColorSizeNumber         = new ColorSizeNumber();
                    foreach ($getAllDetailOrderByIdOrder as $itemOrder) {
                        $objColorSizeNumber2    = clone $objColorSizeNumber;
                        $getDataColorSizeNumber = $objColorSizeNumber2->where('product_id', $itemOrder['product_id'])
                            ->where('size_id', $itemOrder['size_id'])
                            ->where('color_id', $itemOrder['color_id'])->first();
                        $getDataColorSizeNumber->number -= $itemOrder['number'];
                        $getDataColorSizeNumber->save();

                    }
                }
                //Sent mail to this user
                Mail::send('mail.order', ['getUserById' => $getUserById], function ($message) use ($getUserById) {
                    $message->subject("Status of Order at SmartOSC's Shop");
                    $message->from('khienpc.sosc@gmail.com');
                    $message->to($getUserById['email']);
                });


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

    public function analytics()
    {
        return view('order.analytics');
    }

    public function analyticsView(Request $request)
    {
        $allRequest = $request->all();
        //========================================Check time Start & End================================================
        if (!isset($allRequest['start']) || $allRequest['start'] == null) {
            return redirect()->action('OrderController@analytics')->withErrors(Lang::get('messages.time_start_empty'));
        }
        if ($allRequest['start'] != null) {
            $start = $allRequest['start'];
            $date  = new DateTime($start);
            $start = $date->format('Y/m/d');
        }
        if (!isset($allRequest['end']) || $allRequest['end'] == null) {
            $end = date("Y/m/d");
        } else {
            $end  = $allRequest['end'];
            $date = new DateTime($end);
            $end  = $date->format('Y/m/d');
        }
        if ($start > $end) {
            return redirect()->action('OrderController@analytics')->withErrors(Lang::get('messages.set_time_again'));
        }
        //========================================END-Check time Start & End============================================
        //===============================Get info order (pending, delevery, ok, cancel)=================================
        $objOrder                      = new Order();
        $getDataOrderOk                = $objOrder
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->where('status', Order::OK)
            ->get();
        $orderOk['count']              = $getDataOrderOk->count();
        $orderOk['total_cost']         = $getDataOrderOk->sum('total_cost');
        $orderOk['total_price_import'] = $getDataOrderOk->sum('total_price_import');
        $orderOk['total_profit']       = $orderOk['total_cost'] - $orderOk['total_price_import'];

        $getDataOrderPending                = $objOrder
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->where('status', Order::PENDING)
            ->get();
        $orderPending['count']              = $getDataOrderPending->count();
        $orderPending['total_cost']         = $getDataOrderPending->sum('total_cost');
        $orderPending['total_price_import'] = $getDataOrderPending->sum('total_price_import');
        $orderPending['total_profit']       = $orderPending['total_cost'] - $orderPending['total_price_import'];

        $getDataOrderDelevery                = $objOrder
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->where('status', Order::DELEVERY)
            ->get();
        $orderDelevery['count']              = $getDataOrderDelevery->count();
        $orderDelevery['total_cost']         = $getDataOrderDelevery->sum('total_cost');
        $orderDelevery['total_price_import'] = $getDataOrderDelevery->sum('total_price_import');
        $orderDelevery['total_profit']       = $orderDelevery['total_cost'] - $orderDelevery['total_price_import'];


        $getDataOrderCancel                = $objOrder
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->where('status', Order::CANCEL)
            ->get();
        $orderCancel['count']              = $getDataOrderCancel->count();
        $orderCancel['total_cost']         = $getDataOrderCancel->sum('total_cost');
        $orderCancel['total_price_import'] = $getDataOrderCancel->sum('total_price_import');
        $orderCancel['total_profit']       = $orderCancel['total_cost'] - $orderCancel['total_price_import'];
        //===========================END-Get info order (pending, delevery, ok, cancel)=================================

        //===========================================Get hot Product====================================================
        $getArrayDataOrderOk = $getDataOrderOk->toArray();
        if (!empty($getArrayDataOrderOk)) {
            $objDetailOrder = new DetailOrder();
            $objDetailOrder = $objDetailOrder->selectRaw('detail_order.product_id,
            product.name_product,
            product.key_product,
            sum(detail_order.number) as sum')
                ->leftJoin('product', 'product.id', '=', 'detail_order.product_id');
            foreach ($getArrayDataOrderOk as $item) {
                $objDetailOrder = $objDetailOrder->orwhere('detail_order.order_id', $item['id']);
            }
            $getHotProduct = $objDetailOrder->groupBy('detail_order.product_id')
                ->orderBy('sum', 'desc')
                ->take(10)
                ->get()
                ->toArray();

        }
        //=======================================END-Get hot Product====================================================

        return view('order.analyticsView')->with([
            'orderPending'  => $orderPending,
            'orderOk'       => $orderOk,
            'orderDelevery' => $orderDelevery,
            'orderCancel'   => $orderCancel,
            'start'         => $start,
            'end'           => $end,
            'getHotProduct' => $getHotProduct,
        ]);
    }

    public function analyticsView2()
    {

        $objOrder = new Order();

        $getDataOrderOk = $objOrder
            ->where('created_at', '>=', "2015/07/01")
            ->where('created_at', '<=', "2015/07/30")
            ->where('status', Order::OK)
            ->get()->toArray();
        var_dump($getDataOrderOk);
        if (!empty($getDataOrderOk)) {
            $objDetailOrder = new DetailOrder();
            $objDetailOrder = $objDetailOrder->selectRaw('product_id, sum(number) as sum');
            foreach ($getDataOrderOk as $item) {
                $objDetailOrder = $objDetailOrder->orwhere('order_id', $item['id']);
            }
            $objDetailOrder = $objDetailOrder->groupBy('product_id')->get();
            var_dump($objDetailOrder->toArray());
            die();
        }


    }
}

