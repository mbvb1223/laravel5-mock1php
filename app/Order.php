<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Session;
use Lang;
use Route;


class Order extends Model
{
    protected $guarded = ['id'];
    protected $table = 'order';
    public $properties = array('id', 'user_id', 'status','token', 'total_price_import',
        'total_price', 'total_cost', 'information', 'created_at', 'updated_at');
    public $timestamps = true;

    const PENDING = 0;
    const DELEVERY = 1;
    const OK = 2;
    const CANCEL = 3;

    /**
     * For BackEnd
     */
    public function getDataForPaginationAjax($allRequest)
    {
        $pageCurrent = $allRequest['current'];
        $limit       = $allRequest['rowCount'];
        $offset      = ($pageCurrent - 1) * $limit;

        // Config sort
        $sortBy    = 'id';
        $sortOrder = 'asc';

        if (isset($allRequest['sort'])) {
            $sort      = $allRequest['sort'];
            $sortColum = ['id', 'user_id', 'status','token',
                'total_price_import', 'total_price', 'total_cost',
                'information', 'created_at', 'updated_at'];
            $sortBy    = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $query = $this->where(function($query) use ($allRequest) {
                            $query->where('id', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                ->orWhere('user_id', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                ->orWhere('status', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                ->orWhere('total_cost', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                ->orWhere('created_at', 'LIKE', '%' . $allRequest['searchPhrase'] . '%');
        });

        $queryGetTotal = $query;
        $total         = $queryGetTotal->count();

        if ($limit == -1) {
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->get();
        } else {
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->skip($offset)
                ->take($limit)
                ->get();
        }

        // Render field action
        foreach ($rows as $k => $item) {
            $rows[$k]['action'] = create_field_action('admin/order', $item->id);
        }

        $data['current']  = intval($pageCurrent);
        $data['rowCount'] = intval($limit);
        $data['total']    = intval($total);
        $data['rows']     = $rows;
        $data['_token']   = csrf_token();
        return json_encode($data);
    }

    public static function updateCostPriceAndPriceImportInOrderByIdOrder($idOrder){
        //update price/cost/price_import in table Order
        $objDetailOrder = new DetailOrder();
        $getAllProductInDetailOrderByIdOrder = $objDetailOrder->where('order_id', $idOrder)->get();
        $totalCost                           = 0;
        $totalPrice                          = 0;
        $totalPriceImport                    = 0;

        foreach ($getAllProductInDetailOrderByIdOrder as $item) {

            $totalCost          += $item['number'] * $item['cost'];
            $totalPrice         +=  $item['number'] * $item['price'];
            $totalPriceImport   +=  $item['number'] * $item['price_import'];
        }

        $getOrderById = Order::find($idOrder);
        $getOrderById->total_cost = $totalCost;
        $getOrderById->total_price = $totalPrice;
        $getOrderById->total_price_import = $totalPriceImport;
        $getOrderById->save();
    }

    public static function getViewStatusForOrder($currentStatus){
        $result = null;
        if($currentStatus==self::PENDING){

            $result.= "<div class='col-md-3'><input type='radio' checked name='status' style='margin-left:0px;' value='".self::PENDING."'>PENDING</div>";
            $result.= "<div class='col-md-3'><input type='radio' style='margin-left:0px;' name='status' value='".self::DELEVERY."'>DELEVERY</div>";
            $result.= "<div class='col-md-3'><input type='radio' style='margin-left:0px;' name='status' value='".self::OK."'>OK</div>";
            $result.= "<div class='col-md-3'><input type='radio' style='margin-left:0px;' name='status' value='".self::CANCEL."'>CANCEL</div>";

        }
        if($currentStatus==self::DELEVERY){
            $result.= "<div class='col-md-3'><input type='radio' checked style='margin-left:0px;' name='status' value='".self::DELEVERY."'>DELEVERY</div>";
            $result.= "<div class='col-md-3'><input type='radio' style='margin-left:0px;' name='status' value='".self::OK."'>OK</div>";
            $result.= "<div class='col-md-3'><input type='radio' style='margin-left:0px;' name='status' value='".self::CANCEL."'>CANCEL</div>";

        }
        if($currentStatus==self::OK){
            $result.= "<div class='col-md-3'><input type='radio' checked style='margin-left:0px;' name='status' value='".self::OK."'>OK</div>";

        }
        if($currentStatus==self::CANCEL){
            $result.= "<div class='col-md-3'><input type='radio' checked style='margin-left:0px;' name='status' value='".self::CANCEL."'>CANCEL</div>";

        }
        return $result;

    }

    /**
     * For FrontEnd
     */
    public function getViewForCartInFrontEnd($sessionOrder)
    {
        if ($sessionOrder == null) {
            $result = '<h3>Your shopping cart is empty!</h3>';
            return $result;
        }

        $mapProductIdToInformationProduct = Product::mapProductIdToInformationProduct();
        $mapIdColorToInformationColor     = Color::mapIdColorToInformationColor();
        $mapIdSizeToInformationSize       = Size::mapIdSizeToInformationSize();
        $result                           = '';
        $result .= "<form class='form-horizontal form-row-seperated' action='" . action('FrontendController@updateorder') . "' method='Post'>
                   <input type='hidden' name='_token' value='" . csrf_token() . "'> <div class='goods-page'>
                    <div class='goods-data clearfix'>
                        <div class='table-wrapper-responsive'>
                            <table summary='Shopping cart'>
                                <tr>
                                    <th class='goods-page-image'>Image</th>
                                    <th class='goods-page-description'>Description</th>
                                    <th class='goods-page-quantity'>Quantity</th>
                                    <th class='goods-page-price'>Unit price</th>
                                    <th class='goods-page-total' colspan='2'>Total</th>
                                </tr>";

        $totalCost = 0;
        foreach ($sessionOrder as $sessionOrder) {
            $idProduct             = $sessionOrder['product_id'];
            $idColor               = $sessionOrder['color_id'];
            $idSize                = $sessionOrder['size_id'];
            $number                = $sessionOrder['number'];
            $nameProduct           = $mapProductIdToInformationProduct[$idProduct]['name_product'];
            $colorName             = $mapIdColorToInformationColor[$idColor]['color_name'];
            $sizeValue             = $mapIdSizeToInformationSize[$idSize]['size_value'];
            $costProduct           = $mapProductIdToInformationProduct[$idProduct]['cost'];
            $costItemProductInCart = $costProduct * $number;
            $totalCost += $costItemProductInCart;
            $keyOfOrder = $sessionOrder['key'];

            $result .= " <tr>
                            <td class='goods-page-image'>
                                <a href='#'><img src='../../assets/frontend/pages/img/products/model4.jpg' alt='Berry Lace Dress'></a>
                            </td>
                            <td class='goods-page-description'>
                                <h3><a href='#'> $nameProduct</a></h3>
                                <p><strong>Color:</strong> $colorName || <strong>Size: </strong>$sizeValue</p>
                                <em>More info is here</em>
                            </td>
                            <td class='goods-page-quantity'>
                                <div class='product-quantity'>
                                    <input id='product-quantity2' type='text' name='mapKeyToNumber[$keyOfOrder]' value='$number' readonly class='form-control input-sm'>
                                </div>
                            </td>
                            <td class='goods-page-price'>
                                <strong><span>$</span> $costProduct</strong>
                            </td>
                            <td class='goods-page-total'>
                                <strong><span>$</span> $costItemProductInCart</strong>
                            </td>
                            <td class='del-goods-col'>
                                <a class='del-goods' href='" . action('FrontendController@deletecartitem', array('id' => $keyOfOrder)) . "'>&nbsp;</a>
                            </td>
                        </tr>";
        }


        $result .= "</table>
                        </div>
                        <div class='shopping-total'>
                            <ul>
                                <li>
                                    <em>Sub total</em>
                                    <strong class='price'><span>$ </span>$totalCost</strong>
                                </li>
                                <li>
                                    <em>Shipping cost</em>
                                    <strong class='price'><span>$ </span>3.00</strong>
                                </li>
                                <li class='shopping-total-price'>
                                    <em>Total</em>
                                     <strong class='price'><span>$ </span>$totalCost</strong>
                                </li>
                            </ul>
                        </div>
                        </div>
                        <button class='btn btn-default' type='button'><a href='cc'> Continue shopping </a> <i class='fa fa-shopping-cart'></i></button>
                        <button class='btn btn-default' type='submit'>Update <i class='fa fa-check'></i></button>
                        <button class='btn btn-primary' type='button'><a href='" . action('FrontendController@checkout') . "'style='color:white;'> Checkout</a> <i class='fa fa-check'></i></button>
                        <a class='btn btn-default' href='cc'>Delete cart </a>
                        </div></form>";
        return $result;
    }

    public function getViewCartInIndexFrontEnd($sessionOrder)
    {
        if ($sessionOrder == null) {
            $result = '<h3>Your shopping cart is empty!</h3>';
            return $result;
        }

        $mapProductIdToInformationProduct = Product::mapProductIdToInformationProduct();
        $mapIdColorToInformationColor     = Color::mapIdColorToInformationColor();
        $mapIdSizeToInformationSize       = Size::mapIdSizeToInformationSize();
        $result                           = '';
        $totalCost = 0;
        foreach ($sessionOrder as $sessionOrder) {
            $idProduct             = $sessionOrder['product_id'];
            $idColor               = $sessionOrder['color_id'];
            $idSize                = $sessionOrder['size_id'];
            $number                = $sessionOrder['number'];
            $nameProduct           = $mapProductIdToInformationProduct[$idProduct]['name_product'];
            $colorName             = $mapIdColorToInformationColor[$idColor]['color_name'];
            $sizeValue             = $mapIdSizeToInformationSize[$idSize]['size_value'];
            $costProduct           = $mapProductIdToInformationProduct[$idProduct]['cost'];
            $costItemProductInCart = $costProduct * $number;
            $totalCost += $costItemProductInCart;
            $keyOfOrder = $sessionOrder['key'];
            $result .= " <li>
                        <a href='shop-item.html'><img src='' alt='Rolex Classic Watch' width='37' height='34'></a>
                        <span class='cart-content-count'>x $number</span>
                        <strong><a href='shop-item.html'>$nameProduct|$colorName|$sizeValue</a></strong>
                        <em>$$costProduct</em>
                        <a href='" . action('FrontendController@deletecartitem', array('id' => $keyOfOrder)) . "' class='del-goods'>&nbsp;</a>
                    </li>";
        }
        $return[0] = $result;
        $return[1] = $totalCost;
        return $return;
    }

    public function updateNumberForSessionOrder($sessionOrder, $allRequest)
    {
        $mapKeyToNumber = $allRequest['mapKeyToNumber'];

        if (empty($mapKeyToNumber)) {
            return redirect()->action('FrontendController@view');
        }

        foreach ($mapKeyToNumber as $key => $number) {
            if ($number == 0) {
                unset($sessionOrder[$key]);
                continue;
            }
            $sessionOrder[$key]['number'] = $number;
        }
        Session::put('order', $sessionOrder);

    }

    public function submitDataCheckoutToTableOrderAndDetailOrder($sessionOrder, $idUser, $informationForOrder)
    {
        //Submit data to table Order
        $totalCost                        = 0;
        $totalPrice                       = 0;
        $totalPriceImport                 = 0;
        $mapProductIdToInformationProduct = Product::mapProductIdToInformationProduct();

        foreach ($sessionOrder as $itemOrder) {
            $costProduct        = $mapProductIdToInformationProduct[$itemOrder['product_id']]['cost'];
            $priceProduct       = $mapProductIdToInformationProduct[$itemOrder['product_id']]['price'];
            $priceImportProduct = $mapProductIdToInformationProduct[$itemOrder['product_id']]['price_import'];

            $totalCost += $costProduct;
            $totalPrice += $priceProduct;
            $totalPriceImport += $priceImportProduct;

            $statusOrder = self::PENDING;
        }
        $this->user_id            = $idUser;
        $this->total_cost         = $totalCost;
        $this->total_price        = $totalPrice;
        $this->total_price_import = $totalPriceImport;
        $this->status             = $statusOrder;
        $this->information        = $informationForOrder;
        $this->save();

        //Submit data to Table Detail_order
        $idOrder = $this->id;
        $dateTimeCreatedAndUpdated        = new \DateTime();
        foreach ($sessionOrder as $itemOrder) {

            $idProduct = $itemOrder['product_id'];
            $idColor   = $itemOrder['color_id'];
            $idSize    = $itemOrder['size_id'];
            $number    = $itemOrder['number'];

            $costProduct        = $mapProductIdToInformationProduct[$itemOrder['product_id']]['cost'];
            $priceProduct       = $mapProductIdToInformationProduct[$itemOrder['product_id']]['price'];
            $priceImportProduct = $mapProductIdToInformationProduct[$itemOrder['product_id']]['price_import'];

            $dataInsertToTableDetailOrder[] = array(
                'product_id'   => $idProduct,
                'color_id'     => $idColor,
                'size_id'      => $idSize,
                'number'       => $number,
                'price_import' => $priceImportProduct,
                'price'        => $priceProduct,
                'cost'         => $costProduct,
                'order_id'   => $idOrder,
                'created_at'        => $dateTimeCreatedAndUpdated,
                'updated_at'        => $dateTimeCreatedAndUpdated
            );
        }
        $objDetailOrder = new DetailOrder();
        $objDetailOrder->insert($dataInsertToTableDetailOrder);


    }

    public function getViewFormLoginForCheckout()
    {
        $result = "";
        $result .= "<div id='checkout' class='panel panel-default'>
                        <div class='panel-heading'>
                            <h2 class='panel-title'>
                                <a data-toggle='collapse' data-parent='#checkout-page' href='#checkout-content' class='accordion-toggle'>
                                    Step 1: Account login
                                </a>
                            </h2>
                        </div>

                    </div>";
        return $result;
    }

    public function getViewInfoUserAndAddressForCheckout($infoUser)
    {
        $infoUser = $infoUser->toArray();
        $result   = "";
        $result .= "<div id='payment-address' class='panel panel-default'>
                        <div class='panel-heading'>
                            <h2 class='panel-title'>
                                <a data-toggle='collapse' data-parent='#checkout-page' href='#payment-address-content' class='accordion-toggle'>
                            Step 2: Account &amp; Billing Details
                            </a>
                            </h2>
                        </div>
                        <div id='payment-address-content' class='panel-collapse collapse in'>
                            <div class='panel-body row'>
                                <div class='col-md-6 col-sm-6'>
                                    <h3>Your Personal Details</h3>
                                    <div class='form-group'>
                                        <label for='lastname'>Username <span class='require'>*</span></label>
                                        <input readonly type='text' id='username' name='username' value='" . $infoUser['username'] . "' class='form-control'>
                                    </div>
                                    <div class='form-group'>
                                        <label for='email'>E-Mail <span class='require'>*</span></label>
                                        <input readonly type='text' id='email' name='email' value='" . $infoUser['email'] . "'  class='form-control'>
                                    </div>
                                    <div class='form-group'>
                                        <label for='telephone'>Telephone <span class='require'>*</span></label>
                                        <input type='text' id='phone' name='phone' value='" . $infoUser['phone'] . "'  class='form-control'>
                                    </div>
                                </div>
                                <div class='col-md-6 col-sm-6'>
                                    <h3>Your Address</h3>

                                    <div class='form-group'>
                                        <label for='city_id'>City <span class='require'>*</span></label>
                                        <select class='form-control input-sm' name='city_id' id='city_id'>";

        $result .= City::getViewSelectTagCity($infoUser['city_id']);

        $result .= "</select>
                                    </div>
                                    <div class='form-group'>
                                        <label for='region-state'>Region <span class='require'>*</span></label>
                                        <input hidden value='" . $infoUser['region_id'] . "' id='region_id_selected'>
                                        <select class='form-control input-sm' name='region_id' id='region_id'>

                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <label for='address2'>Address</label>
                                        <input type='text' id='address' name='address' value='" . $infoUser['address'] . "' class='form-control'>
                                    </div>
                                </div>
                                <hr>
                                <div class='col-md-12'>
                                    <button class='btn btn-primary  pull-right' type='button' data-toggle='collapse' data-parent='#checkout-page' data-target='#information-content' id='button-payment-address'>Continue</button>

                                </div>
                            </div>
                        </div>
                    </div>";
        return $result;

    }

    public function getViewFormLoginForCheckoutIfNotLogin()
    {
        $result = "";
        $result .= "<div id='checkout' class='panel panel-default'>
    <div class='panel-heading'>
        <h2 class='panel-title'>
            <a data-toggle='collapse' data-parent='#checkout-page' href='#checkout-content' class='accordion-toggle'>
                Step 1: Checkout Options
            </a>
        </h2>
    </div>
    <div id='checkout-content' class='panel-collapse collapse in'>
        <div class='panel-body row'>
            <div class='col-md-6 col-sm-6'>
                <h3>New Customer</h3>
                <p>Checkout Options:</p><label>Guest Checkout</label>

                <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                <button class='btn btn-primary' type='submit' data-toggle='collapse' data-parent='#checkout-page' data-target='#payment-address-content'>Continue</button>
            </div>
            <div class='col-md-6 col-sm-6'>
                <h3>Returning Customer</h3>
                <p>I am a returning customer.</p>
                <form role='form' action='".action('\App\Http\Controllers\Auth\AuthController@postLoginToBuy')."' method='post'>
                    <input type='hidden' name='_token' value='".csrf_token()."'>
                    <div class='form-group'>
                        <label for='email-login'>E-Mail</label>
                        <input type='text' class='form-control' name='username'
                               value='".old('username')."' id='username'
                               placeholder='".Lang::get('messages.users_username')."'
                               required='required'/>
                    </div>
                    <div class='form-group'>
                        <label for='password-login'>Password</label>
                        <input type='password' class='form-control' name='password'
                               id='password'
                               placeholder='". Lang::get('messages.users_password')."'
                               required='required'/>
                    </div>
                    <a href='#'>Forgotten Password?</a>
                    <div class='padding-top-20'>
                        <button class='btn btn-primary' type='submit'>Login</button>
                    </div>
                    <hr>
                    <div class='login-socio'>
                        <p class='text-muted'>or login using:</p>
                        <ul class='social-icons'>
                            <li><a href='#' data-original-title='facebook' class='facebook' title='facebook'></a></li>
                            <li><a href='#' data-original-title='Twitter' class='twitter' title='Twitter'></a></li>
                            <li><a href='#' data-original-title='Google Plus' class='googleplus' title='Google Plus'></a></li>
                            <li><a href='#' data-original-title='Linkedin' class='linkedin' title='LinkedIn'></a></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>";
        return $result;
    }

    public function getViewInfoUserAndAddressForCheckoutIfNotLogin()
    {
        $infoUser = array();
        $result   = "";
        $result .= "<div id='payment-address' class='panel panel-default'>
                        <div class='panel-heading'>
                            <h2 class='panel-title'>
                                <a data-toggle='collapse' data-parent='#checkout-page' href='#payment-address-content' class='accordion-toggle collapsed'>
                            Step 2: Account &amp; Billing Details
                            </a>
                            </h2>
                        </div>
                        <div id='payment-address-content' class='panel-collapse collapse'>
                            <div class='panel-body row'>
                                <div class='col-md-6 col-sm-6'>
                                    <h3>Your Personal Details</h3>
                                    <div class='form-group'>
                                        <label for='yourname'>Your name <span class='require'>*</span></label>
                                        <input  type='text' id='yourname' name='yourname'  class='form-control'>
                                    </div>
                                    <div class='form-group'>
                                        <label for='email'>E-Mail <span class='require'>*</span></label>
                                        <input  type='text' id='email' name='email'  class='form-control'>
                                    </div>
                                    <div class='form-group'>
                                        <label for='telephone'>Telephone <span class='require'>*</span></label>
                                        <input type='text' id='phone' name='phone'  class='form-control'>
                                    </div>
                                </div>
                                <div class='col-md-6 col-sm-6'>
                                    <h3>Your Address</h3>
                                    <div class='form-group'>
                                        <label for='city_id'>City <span class='require'>*</span></label>
                                        <select class='form-control input-sm' name='city_id' id='city_id'>";

        $result .= City::getViewSelectTagCity();

        $result .= "</select>
                                    </div>
                                    <div class='form-group'>
                                        <label for='region-state'>Region <span class='require'>*</span></label>
                                        <input hidden  id='region_id_selected'>
                                        <select class='form-control input-sm' name='region_id' id='region_id'>

                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <label for='address'>Address</label>
                                        <input type='text' id='address' name='address' class='form-control'>
                                    </div>
                                </div>
                                <hr>
                                <div class='col-md-12'>
                                    <button class='btn btn-primary  pull-right' type='button' data-toggle='collapse' data-parent='#checkout-page' data-target='#information-content' id='button-payment-address'>Continue</button>

                                </div>
                            </div>
                        </div>
                    </div>";
        return $result;

    }

    public function getViewCartForSubmitCheckout($sessionOrder)
    {
        if ($sessionOrder == null) {
            $result = '<h3>Your shopping cart is empty!</h3>';
            return $result;
        }

        $mapProductIdToInformationProduct = Product::mapProductIdToInformationProduct();
        $mapIdColorToInformationColor     = Color::mapIdColorToInformationColor();
        $mapIdSizeToInformationSize       = Size::mapIdSizeToInformationSize();
        $result                           = '';
        $result .= " <div class='panel-body row'>
                     <div class='col-md-12 clearfix'>
                        <div class='table-wrapper-responsive'>
                            <table summary='Shopping cart'>
                                <tr>
                                    <th class='goods-page-image'>Image</th>
                                    <th class='goods-page-description'>Description</th>
                                    <th class='goods-page-quantity'>Quantity</th>
                                    <th class='goods-page-price'>Unit price</th>
                                    <th class='goods-page-total' colspan='2'>Total</th>
                                </tr>";

        $totalCost = 0;
        foreach ($sessionOrder as $sessionOrder) {
            $idProduct             = $sessionOrder['product_id'];
            $idColor               = $sessionOrder['color_id'];
            $idSize                = $sessionOrder['size_id'];
            $number                = $sessionOrder['number'];
            $nameProduct           = $mapProductIdToInformationProduct[$idProduct]['name_product'];
            $colorName             = $mapIdColorToInformationColor[$idColor]['color_name'];
            $sizeValue             = $mapIdSizeToInformationSize[$idSize]['size_value'];
            $costProduct           = $mapProductIdToInformationProduct[$idProduct]['cost'];
            $costItemProductInCart = $costProduct * $number;
            $totalCost += $costItemProductInCart;
            $keyOfOrder = $sessionOrder['key'];

            $result .= " <tr>
                            <td class='goods-page-image'>
                                <a href='#'><img src='../../assets/frontend/pages/img/products/model4.jpg' alt='Berry Lace Dress'></a>
                            </td>
                            <td class='goods-page-description'>
                                <h3><a href='#'> $nameProduct</a></h3>
                                <p><strong>Color:</strong> $colorName || <strong>Size: </strong>$sizeValue</p>
                                <em>More info is here</em>
                            </td>
                            <td class='goods-page-quantity'>
                                <div class=''>
                                    <input type='text' name='mapKeyToNumber[$keyOfOrder]' value='$number' readonly class='form-control'>
                                </div>
                            </td>
                            <td class='goods-page-price'>
                                <strong><span>$</span> $costProduct</strong>
                            </td>
                            <td class='goods-page-total'>
                                <strong><span>$</span> $costItemProductInCart</strong>
                            </td>
                            <td class='del-goods-col'>
                            </td>
                        </tr>";
        }


        $result .= "</table>
                        </div>
                        <div class='shopping-total'>
                            <ul>
                                <li>
                                    <em>Sub total</em>
                                    <strong class='price'><span>$ </span>$totalCost</strong>
                                </li>
                                <li>
                                    <em>Shipping cost</em>
                                    <strong class='price'><span>$ </span>3.00</strong>
                                </li>
                                <li class='shopping-total-price'>
                                    <em>Total</em>
                                     <strong class='price'><span>$ </span>$totalCost</strong>
                                </li>
                            </ul>
                        </div>
                        </div>
                        <div class='clearfix'></div>
                        <button class='btn btn-primary pull-right' type='submit' id='button-confirm'>Confirm Order</button>
                        </div>";
        return $result;
    }
}



