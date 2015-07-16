<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Session;
use Lang;
use Route;


class Invoiceimport extends Model
{
    protected $guarded = ['id'];
    protected $table = 'invoice_import';
    public $properties = array('id', 'user_id', 'total_price', 'information', 'created_at', 'updated_at');
    public $timestamps = true;


    public function getViewCartInvoiceImport($sessionCartConverted)
    {
        $mapProductIdToInformationProduct = $this->mapProductIdToInformationProduct();
        $resultCart                       = null;
        $resultButton                     = null;
        $totalPrice                       = 0;
        foreach ($sessionCartConverted as $k => $value) {
            $keyProduct = $value['product_id'];
            if (!array_key_exists($keyProduct, $mapProductIdToInformationProduct)) {
                continue;
            }
            $nameProduct        = $mapProductIdToInformationProduct["$keyProduct"]['name_product'];
            $priceImportProduct = $mapProductIdToInformationProduct["$keyProduct"]['price_import'];
            $numberProduct      = $value['number'];
            $priceForItem       = $priceImportProduct * $numberProduct;
            $colorName          = $value['color_id'];
            $sizeValue          = $value['size_id'];
            $keyOfCart          = $value['key'];

            $resultCart .= "<tr>";

                $resultCart .= "<td>";
                $resultCart .= $nameProduct;
                $resultCart .= "</td>";

                $resultCart .= "<td>";
                $resultCart .= $colorName . " - " . $sizeValue;
                $resultCart .= "</td>";

                $resultCart .= "<td>";
                $resultCart .= "<input class='text-center' id='number' type='number' name='mapKeyToNumber[$k]' value='" . $numberProduct . "' >";
                $resultCart .= "</td>";

                $resultCart .= "<td>";
                $resultCart .= $priceImportProduct;
                $resultCart .= "</td>";

                $resultCart .= "<td>";
                $resultCart .= $priceForItem;
                $resultCart .= "</td>";

                $resultCart .= "<td>";
                $resultCart .= "<a class='del-goods' href='" . action('InvoiceImportController@delete', array('id' => $keyOfCart)) . "'>&nbsp;</a>";
                $resultCart .= "</td>";

            $resultCart .= "</tr>";

            $totalPrice += $priceForItem;
        }
        $resultButton .= "
                            <ul>
                                <li><strong class='price'><input name='total_price' value='Total: " . $totalPrice . "' readonly/></strong></li>
                            </ul>
                        ";

        $result = array(
            'cart'   => $resultCart,
            'button' => $resultButton,
        );
        return $result;
    }

    public function saveProductToSessionCart($sessionCart, $allRequest)
    {
        $idProduct = $allRequest['product_id'];
        $idColor   = $allRequest['color_id'];

        //If don't isset of $sessionCart OR $sessionCart == null
        if (!Session::has('cart') || $sessionCart == null) {
            $mapSizeToNumber = $allRequest['mapSizeToNumber']; //array['size']=>number
            foreach ($mapSizeToNumber as $idsize => $number) {
                //If Input Tag Number == null then Next.
                if ($number == null) {
                    continue;
                }
                /**
                 * Save to Session Cart: Cart[idproduct|idcolor|idsize] => product, color, size, number
                 */
                $keyOfCart   = $idProduct . "|" . $idColor . "|" . $idsize;
                $valueOfCart = array(
                    'product_id' => intval($idProduct),
                    'color_id'   => intval($idColor),
                    'size_id'    => intval($idsize),
                    'number'     => intval($number)
                );
                Session::put('cart.' . $keyOfCart, $valueOfCart);
            }
            return redirect()->action('InvoiceImportController@import')
                ->withSuccess(Lang::get('messages.create_success'));
        }

        //If isset of $sessionCart AND $sessionCart != null
        $mapSizeToNumber = $allRequest['mapSizeToNumber']; //array['size']=>number
        foreach ($mapSizeToNumber as $size => $number) {
            //If Input Tag Number == null then Next.
            if ($number == null) {
                continue;
            }
            /**
             * Save to Session Cart: Cart[idproduct|idcolor|idsize] => product, color, size, number
             */
            $keyOfCart = $idProduct . "|" . $idColor . "|" . $size;

            /**
             * Check if isset Product in SessionCart
             * if isset then number = oldNumber + currentNumber
             * if don't isset then save Product to SessionCart
             */
            if (array_key_exists($keyOfCart, $sessionCart)) {
                $sessionCart[$keyOfCart]['number'] += $number;
            } else {
                $sessionCart[$keyOfCart] = array(
                    'product_id' => intval($idProduct),
                    'color_id'   => intval($idColor),
                    'size_id'    => intval($size),
                    'number'     => intval($number)
                );
            }
            Session::put('cart', $sessionCart);
        }
    }

    public function mapProductIdToInformationProduct()
    {
        $products = Product::all()->toArray();

        if ($products == null) {
            return null;
        }
        foreach ($products as $product) {
            $mapProductIdToInformationProduct[$product['id']] = $product;
        }
        return $mapProductIdToInformationProduct;
    }


}



