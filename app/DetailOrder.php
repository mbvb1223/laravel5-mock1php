<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetailOrder extends Model {
    protected $guarded = ['id'];
    protected $table = 'detail_order';
    public $properties = array('id', 'product_id','color_id', 'size_id', 'number', 'price_import', 'price', 'cost', 'order_id', 'created_at', 'updated_at');
    public $timestamps = true;


    public function getViewAllDetailOrderByIdOrder($getAllDetailOrderByIdOrder){
        $arrayWithKeyAsProductColorSizeAndNumberBigerZero = ColorSizeNumber::arrayWithKeyAsProductColorSizeAndNumberBigerZero();
        $result = "";
        foreach($getAllDetailOrderByIdOrder as $item){

            $keyOfSessionOrder = $item['product_id']."|".$item['color_id']."|".$item['size_id'];
            if($arrayWithKeyAsProductColorSizeAndNumberBigerZero == null){
                $status = null;
            }else {
                if(array_key_exists($keyOfSessionOrder,$arrayWithKeyAsProductColorSizeAndNumberBigerZero)){
                    if($arrayWithKeyAsProductColorSizeAndNumberBigerZero[$keyOfSessionOrder]['number']>=$item['number']){
                        $status = "<span class='label label-sm label-success'><input type='hidden' name='checkstock[]' value='1'> In stock</span>";
                    }else {
                        $status = "<span class='label label-sm label-danger'><input type='hidden' name='checkstock[]' value='0'> Not enought</span>";
                    }
                }else{
                    $status = "<span class='label label-sm label-danger'><input type='hidden' name='checkstock[]' value='0'> Not in stock</span>";
                }
            }
            $totalCost = $item['cost'] * $item['number'];
            $result .= "<tr>
                <td>
                    <span class='label label-sm label-success'>
                       $status
                    </span>
                </td>
                <td>
                    <a href='#'>$item[product_id] </a>
                </td>

                <td>
                        $item[color_id]
                </td>
                <td>
                       $item[size_id]
                </td>
                <td>
                        $item[number]
                </td>
                <td>
                        $$item[cost]
                </td>
                 <td>
                        $$totalCost
                </td>
                 <td>
                     <a href='".action('OrderController@deleteItemInOrder', $item['id'])."' class='delete-record'>Delete</a>
                </td>

            </tr>";
        }
        return $result;

    }


}



