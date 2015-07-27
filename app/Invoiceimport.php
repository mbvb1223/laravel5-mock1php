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
        $mapIdColorToInformationColor = Color::mapIdColorToInformationColor();
        $mapIdSizeToInformationSize = Size::mapIdSizeToInformationSize();
        $mapProductIdToInformationProduct = $this->mapProductIdToInformationProduct();
        $resultCart                       = null;
        $resultButton                     = null;
        $totalPrice                       = 0;
        foreach ($sessionCartConverted as $k => $value) {
            $idProduct = $value['product_id'];
            if (!array_key_exists($idProduct, $mapProductIdToInformationProduct)) {
                continue;
            }
            $nameProduct        = strip_tags($mapProductIdToInformationProduct["$idProduct"]['name_product']);
            $keyProduct        = strip_tags($mapProductIdToInformationProduct["$idProduct"]['key_product']);
            $priceImportProduct = number_format($mapProductIdToInformationProduct["$idProduct"]['price_import'],2);
            $numberProduct      = $value['number'];
            $priceForItem       = number_format($priceImportProduct * $numberProduct,2);
            $colorName          = $mapIdColorToInformationColor[$value['color_id']]['color_name'];
            $sizeValue          = $mapIdSizeToInformationSize[$value['size_id']]['size_value'];
            $keyOfCart          = $value['key'];

            $resultCart .= "<tr>";

            $resultCart .= "<td>";
            $resultCart .=  "$idProduct|$nameProduct | $keyProduct";
            $resultCart .= "</td>";

            $resultCart .= "<td>";
            $resultCart .= $colorName . " - " . $sizeValue;
            $resultCart .= "</td>";

            $resultCart .= "<td>";
            $resultCart .= "<input class='text-center' id='number' type='number' min='0' name='mapKeyToNumber[$keyOfCart]' value='" . $numberProduct . "' >";
            $resultCart .= "</td>";

            $resultCart .= "<td>";
            $resultCart .= "$ ".$priceImportProduct;
            $resultCart .= "</td>";

            $resultCart .= "<td>";
            $resultCart .= "$ ".$priceForItem;
            $resultCart .= "</td>";

            $resultCart .= "<td>";
            $resultCart .= "<a class='del-goods' href='" . action('InvoiceImportController@delete', array('id' => $keyOfCart)) . "'>&nbsp;</a>";
            $resultCart .= "</td>";

            $resultCart .= "</tr>";

            $totalPrice += $priceForItem;
        }
        $resultButton .= "
                            <ul>
                                <li><strong class='price'>Total: <input name='total_price' value='" . number_format($totalPrice,2) . "' readonly/></strong></li>
                            </ul>
                        ";

        $result = array(
            'cart'   => $resultCart,
            'button' => $resultButton,
        );
        return $result;
    }



    public function getDataForPaginationAjax($allRequest){
        $pageCurrent = $allRequest['current'];
        $limit       = $allRequest['rowCount'];
        $offset      = ($pageCurrent - 1) * $limit;

        // Config sort
        $sortBy    = 'invoice_import.id';
        $sortOrder = 'asc';

        if (isset($allRequest['sort'])) {
            $sort      = $allRequest['sort'];
            $sortColum = ['invoice_import.id', 'invoice_import.total_price', 'invoice_import.information', 'invoice_import.created_at', 'invoice_import.updated_at'];
            $sortBy    = (in_array(key($sort), $sortColum)) ? key($sort) : 'invoice_import.id';
            $sortOrder = current($sort);
        }

        $query   = $this->select('invoice_import.*','users.username','users.email') ->join('users', 'users.id', '=', 'invoice_import.user_id')->where(function($query) use ($allRequest) {
            $query->where('invoice_import.id', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                ->orWhere('users.username', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                ->orWhere('invoice_import.total_price', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                ->orWhere('invoice_import.created_at', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                ->orWhere('invoice_import.updated_at', 'LIKE', '%' . $allRequest['searchPhrase'] . '%');
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
            $rows[$k]['action'] = create_field_action('admin/invoiceimport', $item->id);
        }

//        $arrayFromIdStyleToNameStyle = Style::arrayFromIdStyleToNameStyle();
//        foreach ($rows as $k => $item) {
//            $id =  $rows[$k]['style_id'];
//            $rows[$k]['style_id'] = $arrayFromIdStyleToNameStyle[$id];
//        }


        $data['current']  = intval($pageCurrent);
        $data['rowCount'] = intval($limit);
        $data['total']    = intval($total);
        $data['rows']     = $rows;
        $data['_token']   = csrf_token();
        return json_encode($data);
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

    public function updateNumberForSessionCart($sessionCart, $allRequest)
    {
        $mapKeyToNumber = $allRequest['mapKeyToNumber'];

        if (empty($mapKeyToNumber)) {
            return redirect()->action('InvoiceImportController@view');
        }

        foreach ($mapKeyToNumber as $key => $number) {
            if ($number == 0) {
                unset($sessionCart[$key]);
                continue;
            }
            $sessionCart[$key]['number'] = $number;
        }
        Session::put('cart', $sessionCart);

    }

    public function saveSessionCartToTableInvoiceImport($allRequest)
    {
        $sessionUser           = Session::get('user');
        $userId                = $sessionUser['id'];
        $allRequest['user_id'] = $userId;

        autoAssignDataToProperty($this, $allRequest);
        self::save();

    }

    public function saveSessionCartToTableDetailInvoiceImport($convertAndSortSessionCart)
    {
        $idLastOfInvoiceImport = $this->id;

        $mapProductIdToInformationProduct = Product::mapProductIdToInformationProduct();
        $dateTimeCreatedAndUpdated        = new \DateTime();
        foreach ($convertAndSortSessionCart as $itemCart) {
            $idProduct                              = $itemCart['product_id'];
            $price_import                           = $mapProductIdToInformationProduct[$idProduct]['price_import'];
            $dataInsertToTableDetailInvoiceImport[] = array(
                'product_id'        => $itemCart['product_id'],
                'color_id'          => $itemCart['color_id'],
                'size_id'           => $itemCart['size_id'],
                'number'            => $itemCart['number'],
                'price_import'      => $price_import,
                'invoice_import_id' => $idLastOfInvoiceImport,
                'created_at'        => $dateTimeCreatedAndUpdated,
                'updated_at'        => $dateTimeCreatedAndUpdated
            );
        }
        $objDetailInvoiceImport = new Detailinvoiceimport();
        $objDetailInvoiceImport->insert($dataInsertToTableDetailInvoiceImport);

    }

    public function saveSessionCartToTableColorSizeNumber($convertAndSortSessionCart)
    {
        $dateTimeCreatedAndUpdated     = new \DateTime();
        // array[colorid|sizeid|number|]=>info record in Table color_size_number
        $objColorSizeNumber            = new ColorSizeNumber();
        $arrayWithKeyAsColorSizeNumber = $objColorSizeNumber->arrayWithKeyAsColorSizeNumber();

        //if table color_size_number empty, insert SessionCart
        if ($arrayWithKeyAsColorSizeNumber == null) {
            foreach ($convertAndSortSessionCart as $itemCart) {
                $dataInsertToTableDetailInvoiceImport = array(
                    'product_id' => $itemCart['product_id'],
                    'color_id'   => $itemCart['color_id'],
                    'size_id'    => $itemCart['size_id'],
                    'number'     => $itemCart['number'],
                    'created_at' => $dateTimeCreatedAndUpdated,
                    'updated_at' => $dateTimeCreatedAndUpdated
                );
                $objColorSizeNumber->insert($dataInsertToTableDetailInvoiceImport);

            }
        } else {
            //if table color_size_number NOT empty
            foreach ($convertAndSortSessionCart as $itemCart) {
                /**
                 * check isset product (color,size,number) in Table color_size_number
                 * if isset then newNumber = oldNumber + currentNumber
                 */

                $keyOfSessionCart = $itemCart['key'];
                if (array_key_exists($keyOfSessionCart, $arrayWithKeyAsColorSizeNumber)) {
                    $id                  = $arrayWithKeyAsColorSizeNumber[$keyOfSessionCart]['id'];
                    $objColorSizeNumberbyId = ColorSizeNumber::find($id);

                    $oldNumber     = $objColorSizeNumberbyId->number;
                    $currentNumber = $itemCart['number'];
                    $newNumber     = $currentNumber + $oldNumber;

                    $objColorSizeNumberbyId->number = $newNumber;
                    $objColorSizeNumberbyId->save();
                } else {
                    /**
                     * check isset product (color,size,number) in Table color_size_number
                     * if Not isset then add new record
                     */
                    $dataInsertToTableDetailInvoiceImport = array(
                        'product_id' => $itemCart['product_id'],
                        'color_id'   => $itemCart['color_id'],
                        'size_id'    => $itemCart['size_id'],
                        'number'     => $itemCart['number'],
                        'created_at' => $dateTimeCreatedAndUpdated,
                        'updated_at' => $dateTimeCreatedAndUpdated
                    );
                    $objColorSizeNumber->insert($dataInsertToTableDetailInvoiceImport);

                }

            }
        }
    }
}



