<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ColorSizeNumber extends Model {
    protected $guarded = ['id'];
    protected $table = 'color_size_number';
    public $properties = array('id','product_id','color_id','size_id','number','created_at','updated_at');
    public $timestamps = true;

    public function arrayWithKeyAsColorSizeNumber(){
        $objColorSizeNumber = ColorSizeNumber::all()->toArray();

        if($objColorSizeNumber == null){
            $newArray = null;
            return $newArray;
        }
        foreach($objColorSizeNumber as $item){
            $productId = $item['product_id'];
            $colorId = $item['color_id'];
            $sizeId = $item['size_id'];
            $newkey = $productId ."|".$colorId."|".$sizeId;
            $newArray[$newkey] = $item;
        }
        return $newArray;
    }

}

