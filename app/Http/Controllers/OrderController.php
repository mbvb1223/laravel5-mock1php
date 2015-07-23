<?php
namespace App\Http\Controllers;

use App\DetailOrder;
use App\Http\Requests;
use App\Order;
use App\Users;
use Illuminate\Http\Request;
use App\Http\Requests\HeightRequest;
use App\Height;
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
        $allRequest = $request->all();
        if(isset($allRequest['status'])){
            if($allRequest['status']==2){
                die();
            }
        }
//        dd($allRequest);
        $objOrder               = new Order();
        $getDataForPaginationAjax = $objOrder->getDataForPaginationAjax($allRequest);

        return $getDataForPaginationAjax;
    }

    public function edit($id)
    {
        $objOrder      = new Order;
        $dataOrderById = $objOrder->find($id);

        if ($dataOrderById == null) {
            return redirect()->action('OrderController@index')->withErrors(Lang::get('messages.no_id_order'));
        }

        //get data detail order
        $objDetailOrder = new DetailOrder();
        $getAllDetailOrderByIdOrder =  $objDetailOrder->where('order_id', $id)->get()->toArray(); //apccept toArray; if null=>null

        if(empty($getAllDetailOrderByIdOrder)){
            return redirect()->action('OrderController@index')->withErrors(Lang::get('messages.no_id_order'));
        }
        $getViewAllDetailOrderByIdOrder = $objDetailOrder->getViewAllDetailOrderByIdOrder($getAllDetailOrderByIdOrder);
        $mapIdUserToInfoUser = Users::mapIdUserToInfoUser();

        return view('order.edit')->with([
            'dataOrderById' => $dataOrderById,
            'mapIdUserToInfoUser' => $mapIdUserToInfoUser,
            'getViewAllDetailOrderByIdOrder'=>$getViewAllDetailOrderByIdOrder,

        ]);
    }


    public function update(HeightRequest $request, $id)
    {
        $allRequest     = $request->all();
        $objHeight      = new Height();
        $dataHeightById = $objHeight->find($id);

        if ($dataHeightById == null) {
            return redirect()->action('HeightController@index')->withErrors(Lang::get('messages.no_id'));
        }
        autoAssignDataToProperty($dataHeightById, $allRequest);
        $dataHeightById->save();
        return redirect()->action('HeightController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $objHeight      = new Height();
        $dataHeightById = $objHeight->find($id);

        if ($dataHeightById == null) {
            return redirect()->action('HeightController@index')->withErrors(Lang::get('messages.no_id'));
        }

        $dataHeightById->delete();
        return redirect_success('HeightController@index', Lang::get('messages.delete_success'));
    }

}

