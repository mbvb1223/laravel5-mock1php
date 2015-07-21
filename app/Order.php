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
    public $properties = array('id', 'user_id', 'status', 'total_price_import', 'total_price', 'total_cost', 'information', 'created_at', 'updated_at');
    public $timestamps = true;

    const SENDING = 0;
    const DELEVERY = 1;
    const OK = 2;
    const CANCEL = 3;

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

            $statusOrder = self::SENDING;
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



