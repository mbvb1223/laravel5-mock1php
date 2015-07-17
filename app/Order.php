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
    public $properties = array('id', 'user_id', 'total_price_import', 'total_price', 'total_cost', 'information', 'created_at', 'updated_at');
    public $timestamps = true;

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
        $result .= "<form class='form-horizontal form-row-seperated' action='".action('FrontendController@updateorder')."' method='Post'>
                   <input type='hidden' name='_token' value='".csrf_token()."'> <div class='goods-page'>
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
                        <button class='btn btn-primary' type='button'>Checkout <i class='fa fa-check'></i></button>
                        <a class='btn btn-default' href='cc'>Delete cart </a>
                        </div></form>";
        return $result;
    }

}



